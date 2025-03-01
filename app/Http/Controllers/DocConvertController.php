<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use Dompdf\Dompdf;
use PhpOffice\PhpPresentation\IOFactory as PhpPresentationIOFactory; 
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Shape\Drawing\Base64 as ImageShape;
use PhpOffice\PhpPresentation\Shape\Table;
use PhpOffice\PhpPresentation\Shape\Chart;

class DocConvertController extends Controller
{
    public function convertWordToPdf(Request $request)
{
    // Retrieve the uploaded Word file
    $file = $request->file('file');

    // Store the Word file temporarily
    $path = $file->storeAs('temp', 'document.docx');

    // Load the Word document using PhpWord
    $phpWord = IOFactory::load(storage_path('app/' . $path));

    // Convert Word document to HTML
    $htmlContent = $this->convertWordToHtml($phpWord);

    // Initialize DomPDF
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $dompdf = new Dompdf($options);

    // Load the HTML content into DomPDF
    $dompdf->loadHtml($htmlContent);

    // (Optional) Set paper size
    $dompdf->setPaper('A4', 'portrait');

    // Render PDF (first pass: convert the HTML to PDF)
    $dompdf->render();

    // Save the generated PDF to a file
    $pdfPath = storage_path('app/temp/document.pdf');
    file_put_contents($pdfPath, $dompdf->output());

    // Return the PDF file as a response
    return response()->download($pdfPath)->deleteFileAfterSend(true);
}

private function convertWordToHtml($phpWord)
{
    // Use the built-in method from PhpWord to convert to HTML
    $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
    $htmlContent = '';

    ob_start(); // Start output buffering to capture the HTML
    $htmlWriter->save('php://output'); // Save the HTML to the output buffer
    $htmlContent = ob_get_clean(); // Capture the content of the output buffer

    return $htmlContent;
}
     
    public function convertPptToPdf(Request $request)
    {
        // Retrieve the uploaded PPT file
        $file = $request->file('file');

        // Store the PPT file temporarily
        $path = $file->storeAs('temp', 'document.pptx');

        // Load the PowerPoint document using PHPPresentation
        $ppt = PhpPresentationIOFactory::load(storage_path('app/' . $path));

        // Convert PowerPoint document to HTML
        $htmlContent = $this->convertPptToHtml($ppt);

        // Initialize DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        // Load the HTML content into DomPDF
        $dompdf->loadHtml($htmlContent);

        // (Optional) Set paper size
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (first pass: convert the HTML to PDF)
        $dompdf->render();

        // Save the generated PDF to a file
        $pdfPath = storage_path('app/temp/document.pdf');
        file_put_contents($pdfPath, $dompdf->output());

        // Return the PDF file as a response
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

      private function convertPptToHtml(PhpPresentation $ppt)
    {
        $htmlContent = '<!DOCTYPE html><html><head><style>
            .slide { margin: 20px; padding: 10px; border: 1px solid #ccc; page-break-before: always; }
            .text { font-family: Arial, sans-serif; margin-bottom: 10px; }
            img { max-width: 100%; height: auto; margin-bottom: 10px; }
            table { border-collapse: collapse; width: 100%; margin-bottom: 10px; }
            table, th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
            </style></head><body>';
    
        // Loop through all slides
        foreach ($ppt->getAllSlides() as $slideIndex => $slide) {
            $htmlContent .= '<div class="slide">';
    
            // Loop through all shapes in the slide
            foreach ($slide->getShapeCollection() as $shape) {
                if ($shape instanceof RichText) {
                    // Handle RichText shapes
                    $text = '';
                    foreach ($shape->getParagraphs() as $paragraph) {
                        foreach ($paragraph->getRichTextElements() as $element) {
                            if ($element instanceof \PhpOffice\PhpPresentation\Shape\RichText\Run) {
                                $text .= htmlspecialchars($element->getText());
                            }
                        }
                        $text .= '<br>';
                    }
                    $htmlContent .= '<div class="text">' . $text . '</div>';
                } elseif ($shape instanceof ImageShape) {
                    // Handle Images
                    $imageData = $shape->getImage();
                    $htmlContent .= '<img src="data:image/png;base64,' . base64_encode($imageData) . '" />';
                } elseif ($shape instanceof Table) {
                    // Handle Tables
                    $htmlContent .= '<table>';
                    foreach ($shape->getRows() as $row) {
                        $htmlContent .= '<tr>';
                        foreach ($row->getCells() as $cell) {
                            $cellText = '';
                            foreach ($cell->getParagraphs() as $paragraph) {
                                foreach ($paragraph->getRichTextElements() as $element) {
                                    if ($element instanceof \PhpOffice\PhpPresentation\Shape\RichText\Run) {
                                        $cellText .= htmlspecialchars($element->getText());
                                    }
                                }
                            }
                            $htmlContent .= '<td>' . $cellText . '</td>';
                        }
                        $htmlContent .= '</tr>';
                    }
                    $htmlContent .= '</table>';
                } elseif ($shape instanceof Chart) {
                    // Handle Charts (basic fallback message)
                    $htmlContent .= '<div class="chart">[Chart rendering not supported in HTML]</div>';
                } elseif ($shape instanceof \PhpOffice\PhpPresentation\Shape\Drawing\Gd) {
                // Extract the GD image resource
                $imageResource = $shape->getImageResource();
            
                // Convert the GD image to a Base64 encoded string
                ob_start();
                imagepng($imageResource); // Save the GD image as a PNG in the output buffer
                $imageData = ob_get_clean(); // Get the image data from the buffer
                $htmlContent .= '<img src="data:image/png;base64,' . base64_encode($imageData) . '" />';
            } else {
                    // Handle Unknown or Unsupported Shapes
                    $htmlContent .= '<div class="unsupported">[Unsupported shape]</div>';
                }
            }
    
            $htmlContent .= '</div>'; // Close slide
        }
    
        $htmlContent .= '</body></html>';
    
        return $htmlContent;
    }
}
