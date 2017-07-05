<?php

namespace App\Modules\Pdf\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PDFController extends Controller
{
    public function parse(Request $request)
	{
		$file =$request->file('pdf');
		
		try {
			$parser = new \Smalot\PdfParser\Parser();

			$pdf    = $parser->parseFile($file);
			
			// Retrieve all pages from the pdf file.
			$pages  = $pdf->getPages();

			// Loop over each page to extract text.
			foreach ($pages as $page) {
			    $text = $page->getText();
			}
			$data=array('text'=>$text);
			//return View::make("PDFview", compact('text'));
			return view('pdf::pdfView')->with($data);
			
        } catch (\Exception $e) {
            if ($e->getMessage() != 'This pdf file are currently not supported.May be secured or corrupted!!' && strpos($e->getMessage(), 'TCPDF_PARSER') != 0) {
                        throw $e;
                }
        }
		
	}
}
