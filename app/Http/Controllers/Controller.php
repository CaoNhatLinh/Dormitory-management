<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function config()
    {
        return $config = [
            'js' => [
                'js/plugins/flot/jquery.flot.js',
                'js/plugins/flot/jquery.flot.js',
                'js/plugins/flot/jquery.flot.tooltip.min.js',
                'js/plugins/flot/jquery.flot.spline.js',
                'js/plugins/flot/query.flot.resize.js',
                'js/plugins/flot/query.flot.resize.js',
                'js/plugins/flot/jquery.flot.pie.js',
                'js/plugins/peity/jquery.peity.min.js',
                'js/demo/peity-demo.js',
                'js/inspinia.js',
                'js/plugins/gritter/jquery.gritter.min.js',
                'js/demo/sparkline-demo.js',
                'js/plugins/sparkline/jquery.sparkline.min.js',
                'js/plugins/chartJs/Chart.min.js',
                'js/plugins/toastr/toastr.min.js',

            ]
        ];
    }
}
