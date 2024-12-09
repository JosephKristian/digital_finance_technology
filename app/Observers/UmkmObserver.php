<?php

namespace App\Observers;

use App\Models\Coa;
use App\Models\CoaTemplate;
use App\Models\Umkm;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class UmkmObserver
{
    /**
     * Handle the Umkm "created" event.
     */
    public function saved(Umkm $umkm): void
    {
        Log::info('UMKM Created Observer triggered.', [
            'umkm_id' => $umkm->id,
            'umkm_name' => $umkm->name,
            'timestamp' => now(),
        ]);


        try {
            $templates = CoaTemplate::all();
            Log::info('Fetched all CoaTemplate records.', [
                'total_templates' => $templates->count(),
            ]);
            
        // dd($umkm, $templates);

            foreach ($templates as $template) {
                Log::info('Processing CoaTemplate record.', [
                    'template_id' => $template->id,
                    'account_code' => $template->account_code,
                    'account_name' => $template->account_name,
                ]);

                $coa = Coa::create([
                    'id' => (string) Str::uuid(),
                    'umkm_id' => $umkm->id,
                    'account_code' => $template->account_code,
                    'account_name' => $template->account_name,
                    'account_type' => $template->account_type,
                    'parent_id' => $template->parent_id,
                    'category' => $template->category,
                    'is_default_receipt' => $template->is_default_receipt,
                    'is_default_expense' => $template->is_default_expense,
                ]);

                Log::info('Coa record created successfully.', [
                    'coa_id' => $coa->id,
                    'umkm_id' => $coa->umkm_id,
                    'account_code' => $coa->account_code,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error occurred during Coa creation in UmkmObserver.', [
                'umkm_id' => $umkm->id,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
