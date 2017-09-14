<?php

namespace App\Console\Commands;

use App\Demand\Demand;
use App\Demand\DemandItem;
use App\Demand\Response;
use App\Demand\ResponseItem;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class MailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail {to} {mail} {item} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail selected mail with arguments';



    private function getItem($item, $value)
    {
        $itemValue = null;
        switch($item) {
            case 'demand':
                $itemValue = Demand::find($value);
                break;
            case 'response':
                $itemValue = Response::find($value);
                break;
            case 'responseItem':
                $itemValue =  ResponseItem::find($value);
                break;
            case 'demandItem':
                $itemValue =  DemandItem::find($value);
                break;
            default:
                throw new \Exception('not right item');
        }
        if (!isset($itemValue)) {
            throw new \Exception('not found item by id');
        }
        return $itemValue;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $to = $this->input->getArgument('to');
        $mail = $this->input->getArgument('mail');
        $item = $this->input->getArgument('item');
        $value = $this->input->getArgument('value');
        if (empty($to) or empty($mail) or empty($item) or empty($value)) {
            throw new \Exception(
                sprintf(
                    'not right use! use it\n php artisan mail --to=11@mail.ru --mail=Demand\CancelDemandMail --item=demand --value=1'
                )
            );
        }
        $itemObject = $this->getItem($item, $value);

        $mailClassString = '\\App\Mail\\' . $mail;
        if (!class_exists($mailClassString)) {
            throw new \Exception('not right class name ' . $mailClassString);
        }
        $mailObject = new $mailClassString($itemObject);
        /**
         *
         */
        \Mail::to($to)
            ->send($mailObject);


        $this->comment(PHP_EOL.sprintf('send email class=%s to=%s with item=%s', $mail, $to, $item).PHP_EOL);
    }
}
