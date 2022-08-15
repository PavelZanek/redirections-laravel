<?php

namespace PavelZanek\RedirectionsLaravel\Services;

use PavelZanek\RedirectionsLaravel\Models\Redirect;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportRedirectsService
{
    public function exportItems()
    {
        $response = new StreamedResponse(function(){
            // Open output stream
            $handle = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($handle, [
                'Source URL', 'Target URL', 'Status Code'
            ]);

            Redirect::chunk(500, function($redirects) use($handle) {
                foreach ($redirects as $redirect) {
                    // Add a new row with data
                    fputcsv($handle, [
                        $redirect->source_url,
                        $redirect->target_url,
                        $redirect->status_code->value
                    ]);
                }
            });

            // Close the output stream
            fclose($handle);

        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="export.csv"',
        ]);

        return $response;
    }
}