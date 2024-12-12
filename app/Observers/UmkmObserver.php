<?php

namespace App\Observers;

use App\Models\Coa;
use App\Models\CoaSub;
use App\Models\CoaSubTemplate;
use App\Models\CoaTemplate;
use App\Models\CoaType;
use App\Models\CoaTypeTemplate;
use App\Models\Umkm;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class UmkmObserver
{
    /**
     * Handle the Umkm "created" event.
     */
    public function created(Umkm $umkm): void
    {
        try {
            // Fetch templates
            Log::info('Fetching data templates...');
            // $types = CoaTypeTemplate::all();
            $subs = CoaSubTemplate::all();
            $templates = CoaTemplate::all();
            Log::info('Data templates fetched successfully', [
                // 'total_types' => $types->count(),
                'total_subs' => $subs->count(),
                'total_templates' => $templates->count(),
            ]);

            // Create CoaTypes for the UMKM
            // foreach ($types as $t) {
            //     CoaType::create([
            //         'coa_type_id' => $t->id,
            //         'umkm_id' => $umkm->id,
            //         'type_name' => $t->type_name,
            //     ]);
            //     Log::info('CoaType created', [
            //         'coa_type_id' => $t->id,
            //         'umkm_id' => $umkm->id,
            //         'type_name' => $t->type_name,
            //     ]);
            // }

            // Create CoaSubTemplates
            foreach ($subs as $s) {
                $latestCoaSubId = CoaSub::where('umkm_id', $umkm->id)->max('coa_sub_id') ?? 0;
                $newCoaSubId = $latestCoaSubId + 1;

                $parent_id = $s->parent_id ? CoaSub::where('umkm_id', $umkm->id)
                    ->where('coa_sub_id', $s->parent_id)
                    ->value('coa_sub_id') : null;

                CoaSub::create([
                    'coa_sub_id' => $newCoaSubId,
                    'umkm_id' => $umkm->id,
                    'coa_type_id' => $s->coa_type_id,
                    'sub_name' => $s->sub_name,
                    'parent_id' => $parent_id,
                ]);

                Log::info('CoaSub created', [
                    'coa_sub_id' => $newCoaSubId,
                    'umkm_id' => $umkm->id,
                    'coa_type_id' => $s->coa_type_id,
                    'sub_name' => $s->sub_name,
                    'parent_id' => $parent_id,
                ]);
            }

            // Create CoaTemplates
            foreach ($templates as $template) {
                $coa_sub_id = CoaSub::where('umkm_id', $umkm->id)
                    ->where('coa_sub_id', $template->coa_sub_id)
                    ->value('coa_sub_id');

                $parent_id = $template->parent_id ? Coa::where('umkm_id', $umkm->id)
                    ->where('coa_sub_id', $template->parent_id)
                    ->value('id') : null;

                Coa::create([
                    'id' => (string) Str::uuid(),
                    'umkm_id' => $umkm->id,
                    'coa_sub_id' => $coa_sub_id,
                    'account_code' => $template->account_code,
                    'account_name' => $template->account_name,
                    'parent_id' => $parent_id,
                    'category' => $template->category,
                    'is_default_receipt' => $template->is_default_receipt,
                    'is_default_expense' => $template->is_default_expense,
                ]);

                Log::info('Coa created', [
                    'coa_id' => (string) Str::uuid(),
                    'umkm_id' => $umkm->id,
                    'coa_sub_id' => $coa_sub_id,
                    'account_code' => $template->account_code,
                    'account_name' => $template->account_name,
                    'parent_id' => $parent_id,
                    'category' => $template->category,
                    'is_default_receipt' => $template->is_default_receipt,
                    'is_default_expense' => $template->is_default_expense,
                ]);
            }

            // Log Summary
            Log::info('Process completed successfully', [
                // 'total_types_created' => $types->count(),
                'total_subs_created' => $subs->count(),
                'total_coas_created' => $templates->count(),
            ]);
        } catch (\Exception $e) {
            Log::error('An error occurred during the process', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
