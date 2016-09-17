<?php

//use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;

class EventsSeeder extends CsvSeeder
{
  public function __construct()
    {
        $this->table = 'events';
		$this->csv_delimiter = ';';
        $this->filename = base_path().'/database/seeds/data/events.csv';
		$this->offset_rows = 1;
		$this->mapping = [
			0 => 'title',
			1 => 'description',
			2 => 'address',
			3 => 'zip',
			4 => 'country',
			5 => 'lat',
			6 => 'long',
			7 => 'category',
			8 => 'start',
			9 => 'end',
			10 => 'website',
			11 => 'state',
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
