<?php





namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardMatric extends Controller
{
public function getDashboardData()
{
$weeklyRegisteredUsers = $this->getWeeklyRegisteredUsersData();
$activeUsers = $this->getActiveUsersData();
$recentRegistrations = $this->getRecentRegistrationsData();
$totalSales = $this->getTotalSalesData();
$monthlySales =100;// $this->getMonthlySalesData();
$topSellingCourse = $this->getTopSellingCourseData();
$refundsAndCancellations = $this->getTotalRefundsAndCancellationsData();

$dashboardData = [
['title' => 'Total Sales', 'value' => $totalSales],
['title' => 'Monthly Sales', 'value' => $monthlySales],
['title' => 'Top Selling Course', 'value' => $topSellingCourse],
['title' => 'Active Users', 'value' => $activeUsers],
['title' => 'New Registrations', 'value' => $recentRegistrations],
//['title' => 'Course Completion Rate', 'value' => '75%'], // Placeholder value
['title' => 'Outstanding Invoices', 'value' => '5'], // Placeholder value
//['title' => 'Refunds and Cancellations', 'value' => $refundsAndCancellations],
['title' => 'Open Tickets', 'value' => '3'], // Placeholder value
//['title' => 'Enrollment Numbers', 'value' => '500'], // Placeholder value
['title' => 'Average Time Spent', 'value' => '2 hours'], // Placeholder value
['title' => 'Recent Logins', 'value' => '50'] // Placeholder value
];

return response()->json($dashboardData);
}

private function getWeeklyRegisteredUsersData()
{
return DB::table('users')
->select(DB::raw("strftime('%Y-%W', created_at) as week"), DB::raw('COUNT(*) as totalUsers'))
->groupBy('week')
->orderBy('week', 'desc')
->get();
}

private function getActiveUsersData()
{
$activePeriod = Carbon::now()->subDays(30);
$activeUserIds = ActivityLog::where('action', 'login')
->where('created_at', '>=', $activePeriod)
->pluck('user_id')
->unique();

return User::whereIn('id', $activeUserIds)->count();
}

private function getRecentRegistrationsData()
{
$recentPeriod = Carbon::now()->subDays(30);
return User::where('created_at', '>=', $recentPeriod)->count();
}

private function getTotalSalesData()
{
return DB::table('invoice_product')
->join('invoices', 'invoice_product.invoice_id', '=', 'invoices.id')
->sum(DB::raw('invoice_product.quantity * invoice_product.price'));
}

private function getMonthlySalesData()
{
return DB::table('invoice_product')
->join('invoices', 'invoice_product.invoice_id', '=', 'invoices.id')
->select(
DB::raw('YEAR(invoices.invoice_date) as year'),
DB::raw('MONTH(invoices.invoice_date) as month'),
DB::raw('SUM(invoice_product.quantity * invoice_product.price) as total_sales')
)
->groupBy('year', 'month')
->orderBy('year', 'month')
->get();
}

private function getTopSellingCourseData()
{
$topSellingCourse = DB::table('invoice_product')
->join('products', 'invoice_product.product_id', '=', 'products.id')
->select('products.name', DB::raw('SUM(invoice_product.quantity * invoice_product.price) as total_sales'))
->groupBy('products.id', 'products.name')
->orderBy('total_sales', 'desc')
->first();

return $topSellingCourse ? $topSellingCourse->name : 'N/A';
}

private function getTotalRefundsAndCancellationsData()
{
$refundsAndCancellations = DB::table('invoice_product')
->join('invoices', 'invoice_product.invoice_id', '=', 'invoices.id')
->whereIn('invoices.status', ['cancelled', 'refunded'])
->select(DB::raw('SUM(invoice_product.quantity * invoice_product.price) as total_amount'))
->first();

return $refundsAndCancellations ? $refundsAndCancellations->total_amount : 0;
}
}