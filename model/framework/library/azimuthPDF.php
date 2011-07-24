<?php
require_once('framework/library/fpdf/fpdf.php');
require_once('framework/library/fpdi/fpdi.php');

interface component{
//    public $name;
//    public $x;
//    public $y;
//    public $width;
//    public $height;
//    public $value;

    public function render();
}

interface container{
    public function addComponent(component $newComponent);
    public function renderComponents();
}

class azimuthPDF extends FPDI implements container {

    public $components;

    public function __construct() {
        parent::__construct();
        $this->components = array();
    }

    public function addComponent(component $newComponent) {
        $this->components[$newComponent->name] = $newComponent;
        //array_push($this->components,$newComponent);
    }
    public function renderComponents() {
        foreach($this->components as $component){
            $component->render($pdf);
        }
    }
}

class label implements component{
    public $x;
    public $y;
    public $width;
    public $height;
    public $name;
    public $value;
    public $fontSize;
    public $autoscale;
    public $align;

    private $pdf;

    public function  __construct(azimuthPDF &$pdf, $name, area $area, $value = '', $align = 'C', $fontSize = '12', $autoscale = false) {
        $this->name = $name;
        $this->x = $area->x;
        $this->y = $area->y;
        $this->width = $area->width;
        $this->height = $area->height;
        $this->value = $value;
        $this->fontSize = $fontSize;
        $this->autoscale = $autoscale;
        $this->align = $align;
        $this->pdf = $pdf;
    }

    public function render() {
        $this->pdf->SetFont('Arial', 'B', $this->fontSize);
        if ($this->autoscale) {
            while ($this->pdf->getStringWidth($this->value) < $this->width) {
                $this->fontSize++;
                $this->pdf->SetFont('Arial', 'B', $this->fontSize);
            }
            while ($this->pdf->GetStringWidth($this->value) > $this->width) {
                //echo $pdf->GetStringWidth($this->value) . '<br/>';
                $this->fontSize--;
                $this->pdf->SetFont('Arial', 'B', $this->fontSize);
            }
            while (($this->fontSize / 2) > $this->height) {
                $this->fontSize--;
                $this->pdf->SetFont('Arial', 'B', $this->fontSize);
            }
        }

        $this->pdf->setXY($this->x, $this->y);
        $this->pdf->Cell($this->width, $this->height, $this->value, 0, 0, $this->align, false);
    }

}

class area{
    public $x;
    public $y;
    public $width;
    public $height;

    public function  __construct($x, $y, $width, $height) {
        $this->x = $x;
        $this->y = $y;
        $this->width = $width;
        $this->height = $height;
    }
}

class radioGroup implements container, component {
    public $components;
    public $name;

    private $pdf;

    public function __construct(azimuthPDF &$pdf, $name) {
        $this->name = $name;
        $this->components = array();
        $this->pdf = $pdf;
    }

    public function select($button){
        foreach($this->components as $key => $value){
            $this->components[$key]->selected = false;
        }
        $this->components[$button]->selected = true;
    }

    public function addComponent(component $newComponent) {
        $this->components[$newComponent->name] = $newComponent;
    }

    public function renderComponents() {
        foreach ($this->components as $key => $component) {
            $this->components[$key]->render();
        }
    }

    public function render() {
        $this->renderComponents();
    }
}

class radioButton implements component {
    public $x;
    public $y;
    public $width;
    public $height;
    public $name;
    public $value;
    public $fontSize;
    public $autoscale;
    public $align;
    public $selected;
    private $pdf;

    public function  __construct(azimuthPDF &$pdf, $name, area $area, $selected = false, $value = '', $align = 'C', $fontSize = '12', $autoscale = false) {
        $this->name = $name;
        $this->x = $area->x;
        $this->y = $area->y;
        $this->width = $area->width;
        $this->height = $area->height;
        $this->value = $value;
        $this->fontSize = $fontSize;
        $this->autoscale = $autoscale;
        $this->align = $align;
        $this->selected = $selected;
        $this->pdf = $pdf;

    }

    public function render() {
        if($this->selected){
            $this->value = 'X';
            while ($this->pdf->getStringWidth($this->value) < $this->width) {
                $this->fontSize++;
                $this->pdf->SetFont('Arial', 'B', $this->fontSize);
            }
            while ($this->pdf->GetStringWidth($this->value) > $this->width) {
                $this->fontSize--;
                $this->pdf->SetFont('Arial', 'B', $this->fontSize);
            }
            while (($this->fontSize / 3.25) > $this->height) {
                $this->fontSize--;
                $this->pdf->SetFont('Arial', 'B', $this->fontSize);
            }

            $this->pdf->SetFillColor(0, 0, 255);
            $this->pdf->setXY($this->x, $this->y+.35);
            $this->pdf->Cell($this->width, $this->height, $this->value, 0, 0, $this->align, false);
        }       
    }

    
}


?>
