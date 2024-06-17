<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class ParseCarXml extends Command
{
    protected $signature = 'parse:cars {path?}';
    protected $description = 'Парсинг для данных автомобилей';

    public function handle(): void
    {
        $path = $this->argument('path') ?? base_path('dataCar/data.xml');//

        try {
            if (!is_readable($path)) {
                throw new \Exception('XML не найден/не читаем.');
            }

            $xmlContent = file_get_contents($path);
            $xml = new SimpleXMLElement($xmlContent);

            DB::transaction(function () use ($xml) {
                $existingRecords = DB::table('cars')->pluck('id', 'generation_id')->toArray();
                $incomingRecords = [];

                foreach ($xml->offers->offer as $offer) {
                    $generationId = (int) $offer->generation_id;

                    $data = [
                        'mark' => (string) $offer->mark,
                        'model' => (string) $offer->model,
                        'generation' => (string) $offer->generation,
                        'year' => (int) $offer->year,
                        'run' => (int) $offer->run,
                        'color' => (string) $offer->color,
                        'body_type' => (string) $offer->{'body-type'},
                        'engine_type' => (string) $offer->{'engine-type'},
                        'transmission' => (string) $offer->transmission,
                        'gear_type' => (string) $offer->{'gear-type'},
                        'generation_id' => $generationId,
                        'updated_at' => now(),
                    ];

                    if (isset($existingRecords[$generationId])) {
                        DB::table('cars')->where('generation_id', $generationId)->update($data);
                    } else {
                        DB::table('cars')->insert($data + ['created_at' => now()]);
                    }

                    $incomingRecords[] = $generationId;
                }

                DB::table('cars')->whereNotIn('generation_id', $incomingRecords)->delete();
            });

            $this->info('Парсинг успешно завершён');

        } catch (\Throwable $e) {
            $this->error('Ошибка: ' . $e->getMessage());
        }
    }
}
