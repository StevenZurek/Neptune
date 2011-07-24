<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('framework.php');
require_once('library/fpdf/fpdf.php');
require_once('library/fpdi/fpdi.php');
global $INCLUDE_PATH;

class azimuthPDF extends FPDI {

    public $components;

    public function __construct() {
        parent::__construct();
        $this->components = array();
    }

    public function addComponent($newComponent) {
        $this->components[$newComponent->name] = $newComponent;
        //array_push($this->components,$newComponent);
    }

    public function renderComponents(){
        foreach($this->components as $key => $component){
            $this->components[$key]->render($this);
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

    public function  __construct($name, $area, $value = '') {
        $this->name = $name;
        $this->x = $area->x;
        $this->y = $area->y;
        $this->width = $area->width;
        $this->height = $area->height;
        $this->value = $value;
        $this->fontSize = 16;

        if(empty($this->value)){
            $this->value = $this->name;
        }
    }

    public function render(&$pdf) {
        while($pdf->GetStringWidth($this->value) > $this->width){
            //echo $pdf->GetStringWidth($this->value) . '<br/>';
            $this->fontSize--;
            $pdf->SetFont('Arial','B',$this->fontSize);  
        }

        $pdf->setXY($this->x, $this->y);
        $pdf->Cell($this->width, $this->height, $this->value, 0, 0, 'C', false);

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
$DR2008A = array();
$DR2008A['b2VinArea'] = new area(14.5, 83, 118, 12.5);
$DR2008A['b2YearArea'] = new area(14.5, 105, 14.5, 7.5);
$DR2008A['b2MakeArea'] = new area(29, 105, 21.5, 7.5);
$DR2008A['b2BodyArea'] = new area(51, 105, 21.25, 7.5);
$DR2008A['b2ModelArea'] = new area(72.75, 105, 21.25, 7.5);
$DR2008A['b2ColorArea'] = new area(94, 105, 21.25, 7.5);
$DR2008A['b2StateOfIssueArea'] = new area(115.5, 105, 21.25, 7.5);
$DR2008A['b2PlateNumber'] = new area(137, 105, 27.75, 7.5);
$DR2008A['b2TypeArea'] = new area(165, 105, 14.25, 7.5);
$DR2008A['b2ExpirationDateArea'] = new area(179.5, 105, 27, 7.5);

$DR2008A['b3Name'] = new area(14.5, 121, 123.5, 4.75);
$DR2008A['b3AreaCode'] = new area(140.5, 121, 9, 4.75);
$DR2008A['b3Phone'] = new area(152, 121, 54.5, 4.75);

$DR2008A['b5Name'] = new area(14.5, 148.5, 86., 4.75);
$DR2008A['b5TowReportNumberArea'] = new area(101, 148.5, 49.5, 4.75);
$DR2008A['b5DateNotifiedArea'] = new area(150.75, 148.5, 32.35, 4.75);
$DR2008A['b5TimeArea'] = new area(183.5, 148.5, 23.4, 4.75);

$DR2008A['b6AddressArea'] = new area(27.6, 161.5, 77.9, 4.75);
$DR2008A['b6CityArea'] = new area(105.75, 161.5, 51, 4.75);
$DR2008A['b6CountryArea'] = new area(157, 161.5, 29, 4.75);
$DR2008A['b6MilesTowedArea'] = new area(186.25, 161.5, 20.25, 4.75);
$DR2008A['b6MonthArea'] = new area(27.6, 170.55, 31, 4.75);
$DR2008A['b6DayArea'] = new area(58.85, 170.55, 28.35, 4.75);
$DR2008A['b6YearArea'] = new area(87.45, 170.55, 27.75, 4.75);
$DR2008A['b6HourArea'] = new area(128.75, 170.55, 28.25, 4.75);
$DR2008A['b6MinuteArea'] = new area(157.25, 170.55, 28.25, 4.75);

$DR2008A['b7Name1Area'] = new area(19.3, 180.1, 91.3, 4.3);
$DR2008A['b7Address1Area'] = new area(19.3, 188.5, 91.3, 4.3);
$DR2008A['b7City1Area'] = new area(19.3, 197.8, 51.6, 4.3);
$DR2008A['b7State1Area'] = new area(71.3, 197.8, 14.7, 4.3);
$DR2008A['b7Zip1Area'] = new area(86.2, 197.8, 24.7, 4.3);
$DR2008A['b7AreaCode1Area'] = new area(22.3, 206.7, 11.3, 4.7);
$DR2008A['b7Phone1Area'] = new area(35.9, 206.7, 35.2, 4.7);
$DR2008A['b7PUC1Area'] = new area(71.4, 206.7, 39.5, 4.7);

$DR2008A['b7Name2Area'] = new area(115.7, 180.1, 91.3, 4.3);
$DR2008A['b7Address2Area'] = new area(115.7, 188.5, 91.3, 4.3);
$DR2008A['b7City2Area'] = new area(115.7, 197.8, 53.1, 4.3);
$DR2008A['b7State2Area'] = new area(168.9, 197.8, 15.4, 4.3);
$DR2008A['b7Zip2Area'] = new area(184.5, 197.8, 22.3, 4.3);
$DR2008A['b7AreaCode2Area'] = new area(118.1, 206.7, 11.3, 4.7);
$DR2008A['b7Phone2Area'] = new area(131.7, 206.7, 52.2, 4.7);
$DR2008A['b7DateToDORArea'] = new area(184.5, 206.7, 22.2, 4.7);

$DR2008A['b8AgentNameArea'] = new area(16.3, 219.8, 87.5, 6.3);

$DR2008A['b10AgentNameArea'] = new area(16.3, 244.8, 87, 5.2);



//16.3 219.8

$pdf = new azimuthPDF();
$pagecount = $pdf->setSourceFile('DR2008A.pdf');
$tplidx = $pdf->importPage(1);
$pdf->addPage();
$pdf->useTemplate($tplidx, -10, -5, 230);
$pdf->SetMargins(0, 0);
$pdf->SetFont('Arial','B',16);
//$pdf->addComponent(new label('vinLabel', $b2VinArea, '0123456789ABCDEF'));
//$pdf->addComponent(new label('make', $b2MakeArea, 'FORD'));
//$pdf->addComponent(new label('year', $b2YearArea, '1997'));
//$pdf->renderComponents();

$pdf->SetFillColor(0,0,255);
foreach($DR2008A AS $area){
    $pdf->Rect($area->x, $area->y, $area->width, $area->height, 'F');
}


//$pdf->components['vinLabel']->render(&$pdf);

$pdf->Output('certifiedLetter.pdf', 'D');
 

/*
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image('DR2008A.jpg',0,0,210);


//$pdf->Output();

*/

?>
