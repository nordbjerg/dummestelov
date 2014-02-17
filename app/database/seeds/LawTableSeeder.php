<?php

class LawTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$law = Law::create(array('name' => 'Ordensbekendtgørelsen', 'ministry' => 'JUS'));
		Section::create(array('number' => 1, 'content' => 'asdf', 'law_id' => $law->id));
	}

}