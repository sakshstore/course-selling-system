<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;


use App\Events\LeadCreated;
use App\Events\LeadDeleted;
use App\Events\LeadUpdated;
use App\Models\Lead;
use App\Models\Tag;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{

    public function deleteAll()
    {
// Delete all leads and tags
        Lead::truncate();
        Tag::truncate();

        return response()->json(['message' => 'All leads and tags deleted successfully'], 200);
    }

    public function reportByTags()
    {
        $tags = Tag::withCount('leads')->get();

        $report = $tags->map(function ($tag) {
            return [
                'tag' => $tag->name,
                'total_leads' => $tag->leads_count,
            ];
        });

        return response()->json($report);
    }


    public function dashboardData()
{
$totalLeads = Lead::count();
$leadsByTag = Tag::withCount('leads')->get();
$leadsByStatus = Lead::select('status', \DB::raw('count(*) as total'))
->groupBy('status')
->get();
$leadsByDate = Lead::select(\DB::raw('DATE(created_at) as date'), \DB::raw('count(*) as total'))
->groupBy('date')
->get();

return response()->json([
'totalLeads' => $totalLeads,
'leadsByTag' => $leadsByTag,
'leadsByStatus' => $leadsByStatus,
'leadsByDate' => $leadsByDate,
]);
}



    public function index()
    {
        $leads = Auth::user()->leads()->with('tags')->get()->take(100);
        return response()->json($leads);
    }

    public function getlead(Lead $lead)
    {
        return $lead->load('tags');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'status' => 'required|string|max:50',
        ]);

        $lead = Auth::user()->leads()->create($request->only(['name', 'email', 'phone', 'status']));
        $this->syncTags($lead, $request->tags);

// Dispatch the lead created event
        event(new LeadCreated(auth()->id(), $lead->id));

        return response()->json($lead, 201);
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $lead->status = $request->status;
        $lead->save();

// Dispatch the lead updated event
        event(new LeadUpdated(auth()->id(), $lead->id));

        return response()->json($lead);
    }

    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'status' => 'required|string|max:50',
        ]);

        $lead->update($request->only(['name', 'email', 'phone', 'status']));
        $this->syncTags($lead, $request->tags);

// Dispatch the lead updated event
        event(new LeadUpdated(auth()->id(), $lead->id));

        return response()->json($lead->load('tags'));

    }

    private function syncTags(Lead $lead, $tags)
    {
        if (!is_array($tags)) {
            $tags = explode(',', $tags); // Convert comma-separated string to array
        }

        if ($tags) {
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]); // Trim whitespace
                $tagIds[] = $tag->id;
            }
            $lead->tags()->sync($tagIds);
        }
    }
    public function destroy(Lead $lead)
    {
        $lead->delete();

// Dispatch the lead deleted event
        event(new LeadDeleted(auth()->id(), $lead->id));

        return response()->json(null, 204);
    }

    public function get_lead_status()
    {
        $statuses = ['New', 'Qualified', 'Sold', 'Lost'];
        return response()->json($statuses);
    }

    public function bulkCreate(Request $request)
    {
        $faker = Faker::create();
        $statuses = ['New', 'Qualified', 'Sold', 'Lost'];
        $dummyLeads = [];

        for ($i = 0; $i < 20; $i++) {
            foreach ($statuses as $status) {
                $dummyLeads[] = [
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'status' => $status,

                ];
            }
        }

        foreach ($dummyLeads as $leadData) {
            Auth::user()->leads()->create($leadData);
        }

        return response()->json(['message' => 'Dummy leads created successfully'], 201);
    }

}
