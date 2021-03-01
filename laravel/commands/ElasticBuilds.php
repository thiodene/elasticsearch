<?php
// app > Console > Commands > ElasticBuids.php
namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\ElasticSearchController;
use Elasticsearch\ClientBuilder;

class ElasticBuilds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:builds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command creates a new Index with Mapping; Deletes Index if already exists';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->elastic = new ElasticSearchController();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // If the Index already exists Delete the Index / Remove all existing Data
        $this->elastic->delete_index();
        // If the Index doesn't exist create the Index with Mapping
        $this->elastic->create_index_with_mapping();
        return true;
    }
}
