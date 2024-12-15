<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        /*       $adminRole = Role::create(['name' => 'admin']);

               // Find the user with ID 1
               $user = User::find(1);

               // Assign the admin role to the user
               if ($user) {
                   $user->assignRole($adminRole);
               }
       */
        $users = User::all(); // You can add pagination if needed
        return response()->json($users);
    }
    public function show(User $user)
    {
        return response()->json($user);
    }
    public function contacts(User $user)
    {
        // Corrected: Access the contacts relationship directly
        $contacts = $user->contacts()->with(['notes', 'tags'])->get();
        return response()->json($contacts);
    }

    public function leads(User $user)
    {
        // Corrected: Access the leads relationship directly
        $leads = $user->leads; // Assuming leads is a relationship defined in the User model
        return response()->json($leads);
    }


    public function suspend(User $user)
    {
        $user->update(['is_suspended' => true]);
        return response()->json(['message' => 'User suspended successfully']);
    }

    public function unsuspend(User $user)
    {
        $user->update(['is_suspended' => false]);
        return response()->json(['message' => 'User unsuspended successfully']);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));
        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }




    public function getWeeklyRegisteredUsers()
    {

        /*
        $weeklyRegisteredUsers = DB::table('users')
            ->select(DB::raw('YEARWEEK(created_at) as week'), DB::raw('COUNT(*) as totalUsers'))
            ->groupBy('week')
            ->orderBy('week', 'desc')
            ->get();

*/

        $weeklyRegisteredUsers = DB::table('users')
            ->select(DB::raw("strftime('%W (%Y)', created_at) as week"), DB::raw('COUNT(*) as totalUsers'))
            ->groupBy('week')
            ->orderBy('week', 'desc')
            ->get();




        return response()->json($weeklyRegisteredUsers);
    }
    public function getActiveUsers()
    {
    $activePeriod = Carbon::now()->subDays(30);
    
    // Get user IDs of users who have logged in within the active period
    $activeUserIds = ActivityLog::where('action', 'login')
    ->where('created_at', '>=', $activePeriod)
    ->pluck('user_id')
    ->unique();
    
    // Fetch user details
    $activeUsers = User::whereIn('id', $activeUserIds)->get();
    
    return response()->json($activeUsers);
    }
    public function getRecentRegistrations()
    {
    $recentPeriod = Carbon::now()->subDays(30);
    $recentRegistrations = User::where('created_at', '>=', $recentPeriod)->count();
    
    return response()->json(['recent_registrations' => $recentRegistrations]);
    }


    public function getNewStudents()
{
$newStudents = User::where('created_at', '>=', Carbon::now()->subDays(30))->get();
return response()->json($newStudents);
}

 
public function referralReport()
{
    $user = Auth::user();
    $referrals = $user->referrals()->get();
    $totalIncome = $user->referral_income;

    return response()->json([
        'referrals' => $referrals,
        'totalIncome' => $totalIncome,
    ]);
}


public function generateReferralCode(Request $request)
{
 
    $user = Auth::user();

    
$user->referral_code = $user->id;


$user->save();




$user->referral_link="locahost/".$user->referral_code;


    return response()->json($user);

}
}
