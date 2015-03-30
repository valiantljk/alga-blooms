<?php

class Jpgraph {

    function linechart($plot) {
        require_once("jpgraph/jpgraph.php");
        require_once("jpgraph/jpgraph_line.php");
        require_once("jpgraph/jpgraph_scatter.php");
        require_once ('jpgraph/jpgraph_date.php');
        require_once ('jpgraph/jpgraph_utils.inc.php');
        // Create the graph. These two calls are always required
        $graph = new Graph($plot['width'], $plot['length'], 'auto');
        $graph->img->SetMargin(45, 25, 40, 80);
        $graph->SetScale('textlin');
        // Setup title
        //
        $graph->title->Set($plot['title']);
        $graph->title->SetFont(FF_FONT2, FS_BOLD, 12);
        //set x-axis: angle, data, step
        $graph->xaxis->SetLabelAngle($plot['angle']);
        $graph->xaxis->SetTickLabels($plot['xdata']);
        $graph->xaxis->SetTextLabelInterval($plot['step']);

        if ($plot['by'] == 3) {
            $springplot = new LinePlot($plot['spring']);
            $summerplot = new LinePlot($plot['summer']);
            $fallplot = new LinePlot($plot['fall']);
            $winterplot = new LinePlot($plot['winter']);
            $springplot1 = new ScatterPlot($plot['spring']);
            $summerplot1 = new ScatterPlot($plot['summer']);
            $fallplot1 = new ScatterPlot($plot['fall']);
            $winterplot1 = new ScatterPlot($plot['winter']);
            $springplot1->mark->SetType(MARK_FILLEDCIRCLE);
            $springplot1->mark->SetFillColor("red");
            $springplot1->mark->SetWidth(8);
            $summerplot1->mark->SetType(MARK_FILLEDCIRCLE);
            $summerplot1->mark->SetFillColor("green");
            $summerplot1->mark->SetWidth(4);
            $fallplot1->mark->SetType(MARK_FILLEDCIRCLE);
            $fallplot1->mark->SetFillColor("blue");
            $fallplot1->mark->SetWidth(6);
            $winterplot1->mark->SetType(MARK_FILLEDCIRCLE);
            $winterplot1->mark->SetFillColor("yellow");
            $winterplot1->mark->SetWidth(5);
            $springplot1->SetLegend("Spring");
            $summerplot1->SetLegend("Summer");
            $fallplot1->SetLegend("Fall");
            $winterplot1->SetLegend("Winter");

            $graph->Add($springplot);
            $graph->Add($summerplot);
            $graph->Add($fallplot);
            $graph->Add($winterplot);
            $graph->Add($springplot1);
            $graph->Add($summerplot1);
            $graph->Add($fallplot1);
            $graph->Add($winterplot1);
            $graph->legend->SetPos(0.05, 0, 'left', 'top');
            $graph->legend->SetMarkAbsSize('8');
            $graph->legend->SetColumns(4);
           $graph->xaxis->title->Set("Date");
            $graph->xaxis->title->SetMargin(6);
            $graph->yaxis->title->Set($plot['yaxis']);
            $springplot->SetWeight($plot['weight']);
            $summerplot->SetWeight($plot['weight']);
            $fallplot->SetWeight($plot['weight']);
            $winterplot->SetWeight($plot['weight']);
            error_reporting(E_ERROR | E_PARSE);
        } else {
            $lineplot = new LinePlot($plot['ydata']);
            $sp1 = new ScatterPlot($plot['ydata']);
            $graph->Add($lineplot);
            $graph->Add($sp1);
            //$graph->title->SetFont(FF_FONT1, FS_BOLD);
            //$graph->title->SetCSIMTarget('#45', 'Title for Bar');
            $graph->xaxis->title->Set("Date");
            $graph->xaxis->title->SetMargin(6);
            $graph->yaxis->title->Set($plot['yaxis']);
            $graph->yaxis->title->SetMargin(6);
            // Setup the axis title image map and font style
            $graph->yaxis->title->SetFont(FF_FONT2, FS_BOLD, 22);
            $graph->xaxis->title->SetFont(FF_FONT2, FS_BOLD, 22);

            $lineplot->SetColor($plot['color']);
            $lineplot->SetWeight($plot['weight']);
        }
        error_reporting(E_ERROR | E_PARSE);
        return $graph; // does PHP5 return a reference automatically?
    }

    function scatterchart($plot) {
         require_once("jpgraph/jpgraph.php");
        require_once("jpgraph/jpgraph_line.php");
        require_once("jpgraph/jpgraph_scatter.php");
        require_once ('jpgraph/jpgraph_date.php');
        require_once ('jpgraph/jpgraph_utils.inc.php');
        // Create the graph. These two calls are always required
        $graph = new Graph($plot['width'], $plot['length'], 'auto');
        $graph->img->SetMargin(45, 25, 40, 80);
        $graph->SetScale('textlin');
        $graph->title->Set($plot['title']);
        $graph->title->SetFont(FF_FONT2, FS_BOLD, 12);
        //set x-axis: angle, data, step
        $graph->xaxis->SetLabelAngle($plot['angle']);
        $graph->xaxis->SetTickLabels($plot['xdata']);
        $graph->xaxis->SetTextLabelInterval($plot['step']);
        $graph->xaxis->title->Set("Date");
        $graph->xaxis->title->SetMargin(6);
        if ($plot['by'] == 3) {
            $springplot = new LinePlot($plot['spring']);
            $summerplot = new LinePlot($plot['summer']);
            $fallplot = new LinePlot($plot['fall']);
            $winterplot = new LinePlot($plot['winter']);
            $springplot1 = new ScatterPlot($plot['spring']);
            $summerplot1 = new ScatterPlot($plot['summer']);
            $fallplot1 = new ScatterPlot($plot['fall']);
            $winterplot1 = new ScatterPlot($plot['winter']);
            $springplot1->mark->SetType(MARK_FILLEDCIRCLE);
            $springplot1->mark->SetFillColor("red");
            $springplot1->mark->SetWidth(8);
            $summerplot1->mark->SetType(MARK_FILLEDCIRCLE);
            $summerplot1->mark->SetFillColor("green");
            $summerplot1->mark->SetWidth(4);
            $fallplot1->mark->SetType(MARK_FILLEDCIRCLE);
            $fallplot1->mark->SetFillColor("blue");
            $fallplot1->mark->SetWidth(6);
            $winterplot1->mark->SetType(MARK_FILLEDCIRCLE);
            $winterplot1->mark->SetFillColor("yellow");
            $winterplot1->mark->SetWidth(5);
            $springplot1->SetLegend("Spring");
            $summerplot1->SetLegend("Summer");
            $fallplot1->SetLegend("Fall");
            $winterplot1->SetLegend("Winter");

            //$graph->Add($springplot);
            //$graph->Add($summerplot);
            //$graph->Add($fallplot);
            //$graph->Add($winterplot);
            $graph->Add($springplot1);
            $graph->Add($summerplot1);
            $graph->Add($fallplot1);
            $graph->Add($winterplot1);
            $graph->legend->SetPos(0.03, 0.03, 'left', 'top');
            $graph->legend->SetMarkAbsSize('8');
            $graph->legend->SetColumns(4);

            $graph->yaxis->title->Set($plot['yaxis']);
            $springplot->SetWeight($plot['weight']);
            $summerplot->SetWeight($plot['weight']);
            $fallplot->SetWeight($plot['weight']);
            $winterplot->SetWeight($plot['weight']);
            error_reporting(E_ERROR | E_PARSE);
        } else {
            $lineplot = new LinePlot($plot['ydata']);
            $sp1 = new ScatterPlot($plot['ydata']);
            //$graph->Add($lineplot);
            $graph->Add($sp1);
            //$graph->title->SetFont(FF_FONT1, FS_BOLD);
            //$graph->title->SetCSIMTarget('#45', 'Title for Bar');
            $graph->xaxis->title->Set("Date");
            $graph->xaxis->title->SetMargin(6);
            $graph->yaxis->title->Set($plot['yaxis']);
            $graph->yaxis->title->SetMargin(6);
            // Setup the axis title image map and font style
            $graph->yaxis->title->SetFont(FF_FONT2, FS_BOLD, 22);
            $graph->xaxis->title->SetFont(FF_FONT2, FS_BOLD, 22);

            $lineplot->SetColor($plot['color']);
            $lineplot->SetWeight($plot['weight']);
        }
        error_reporting(E_ERROR | E_PARSE);
        return $graph; // does PHP5 return a reference automatically?
    }

}

