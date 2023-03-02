<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\invoices;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ---------------------- Show "statistics" Charts ----------------------
    public function index()
    {
        //================= احصائية نسبة تنفيذ الحالات======================
        // 1- Number of "all invoices"
        $count_all_invoice =invoices::count();
        // 2- Number of "paid invoices"
        $count_paid_invoices   = invoices::where('value_status', 1)->count();
        // 3- Number of "unpaid invoices"
        $count_unpaid_invoices = invoices::where('value_status', 2)->count();
        // 4- Number of "partial_paid invoices"
        $count_partial_paid    = invoices::where('value_status', 3)->count();
        // 5- Percentage of "paid invoices"
        if($count_paid_invoices == 0)
        {
            $percentage_paid_invoices = 0 ;
        }
        else
        {
            $percentage_paid_invoices = round($count_paid_invoices / $count_all_invoice * 100 , 2);
        }
        // 6- Percentage of "unpaid invoices"
        if($count_unpaid_invoices == 0)
        {
            $percentage_unpaid_invoices = 0 ;
        }
        else
        {
            $percentage_unpaid_invoices = round($count_unpaid_invoices / $count_all_invoice * 100 , 2) ;
        }
        // 7- Percentage of "unpaid invoices"
        if($count_partial_paid == 0)
        {
            $percentage_partial_paid = 0 ;
        }
        else
        {
            $percentage_partial_paid = round($count_partial_paid / $count_all_invoice * 100 , 2) ;
        }
        // ++++++++++++++++++++++++++++++ Chart 1 : barChart ++++++++++++++++++++++++++++++
        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858','',''],
                    'borderColor' => 'transparent' ,
                    'data' => [$percentage_unpaid_invoices, 0 , 0 ]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214','#81b214',''],
                    'borderColor' => 'transparent' ,
                    'data' => [0 , $percentage_paid_invoices , 0]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642','','#ff9642'],
                    'borderColor' => 'transparent' ,
                    'data' => [ 0,0, $percentage_partial_paid ]
                ],
            ])
            ->optionsRaw([
                // labels of "charts"
                'legend' =>
                [
                    'display' => true ,
                    'labels'  =>
                    [
                        'fontColor'  => 'black' ,
                        'fontFamily' => 'Cairo' ,
                        'fontStyle'  => 'bold'  ,
                        'fontSize'   => 11
                    ]
                ] ,
            ])
            ->options([]);
            // ++++++++++++++++++++++++++++++ Chart 2 pieChart ++++++++++++++++++++++++++++++
            $chartjs_2 = app()->chartjs
                ->name('pieChartTest')
                ->type('pie')
                ->size(['width' => 340, 'height' => 200])
                ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
                ->datasets([
                    [
                        'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                        'data' => [$percentage_unpaid_invoices , $percentage_paid_invoices,$percentage_partial_paid]
                    ]
                ])
                ->optionsRaw([
                    // labels of "charts"
                    'legend' =>
                    [
                        'position' => 'bottom' ,
                        'display' => true ,
                        'labels'  =>
                        [
                            'fontColor'  => 'black' ,
                            'fontFamily' => 'Cairo' ,
                            'fontStyle'  => 'bold'  ,
                            'fontSize'   => 11
                        ]
                    ]
                ])
                ->options([]);
           
        // Go To "views/home.blade.php" page and Take two variables "$chartjs" , "$chartjs_2"
        return view('home', compact('chartjs','chartjs_2'));
    }
}
