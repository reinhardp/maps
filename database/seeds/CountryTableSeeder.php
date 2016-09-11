<?php

//use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;

class CountryTableSeeder extends CsvSeeder
{
   public function __construct()
    {
        $this->table = 'countries';
		$this->csv_delimiter = ',';
        $this->filename = base_path().'/database/seeds/data/iso_3166_2_countries.csv';
		$this->offset_rows = 2;
		$this->mapping = [
			1 => 'name',
			10 => 'countrycode',
			11 => 'iso3',
			12 => 'number',
			8 => 'currency',
			14 => 'state',
		];
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table($this->table)->truncate();
        parent::run();
    }
}
