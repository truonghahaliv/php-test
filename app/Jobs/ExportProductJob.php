<?php

namespace App\Jobs;

use App\Exports\ExportProduct;
use App\Models\Product;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writer;

class ExportProductJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
//    protected $start;
//    protected $batchSize;
//
//    public function __construct($start, $batchSize)
//    {
//        $this->start = $start;
//        $this->batchSize = $batchSize;
//    }

    public function handle()
    {
//        (new ExportProduct())->store('public/products.csv');

//        Product::query()
//            ->offset($this->start)
//            ->limit($this->batchSize)
//            ->chunk(1000, function ($users) {
//                $export = new ExportProduct($users);
//                $tempFileName = "product_{$this->start}.csv";
//
//                try {
//                    // Store the file temporarily
//                    Excel::store($export, $tempFileName, 'local');
//                } catch (\Exception $e) {
//                    Log::error("Failed to export users batch starting at {$this->start}: " . $e->getMessage());
//                }
//            });



        $csvPath = storage_path('app/products.csv');

        // Tạo file CSV và viết header
        $csv = \League\Csv\Writer::createFromPath($csvPath, 'w+');
        $csv->insertOne(['id', 'name', 'description', 'price', 'created_at', 'updated_at']); // Thêm các cột phù hợp

        // Chia nhỏ dữ liệu và ghi vào CSV
        DB::table('products')->orderBy('id')->chunk(1000, function($records) use ($csv) {
            foreach ($records as $record) {
                $csv->insertOne((array) $record);
            }
        });
    }
}
