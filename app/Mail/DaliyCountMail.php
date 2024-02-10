<?php

namespace App\Mail;

use Carbon\Carbon;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\TokenDetails;
use App\Models\TokenSeries;

class DaliyCountMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
      
    }

   /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $yeasterday = Carbon::now()->subDay()->format('Y-m-d');
        $from_date =$yeasterday;
        $to_date =$yeasterday;
        $type ='all';
        $section ='all';
        $status ='Completed';
        $result = TokenDetails::whereBetween('post_date', [$from_date, $to_date])
            ->when($section != 'all', function ($query) use ($section) {
                return $query->where('section', $section);
            })
            ->when($type != 'all', function ($query) use ($type) {
                return $query->where('type', $type);
            })
            ->when($status == 'Cancelled', function ($query) use ($status) {
                return $query->whereIn('token_status', ['Pending Registration','Canceled']);
            })
            ->when($status == 'Completed', function ($query) use ($status) {
                return $query->whereNotIn('token_status', ['Pending Registration','Canceled']);
            })
            ->groupBy('type', 'section')
            ->select('type', 'section', DB::raw('COUNT(*) as count'))
            ->get();
        return $this
            ->subject('DHA Daily Report '.$from_date )
            ->view('email.email_temeplet',['result' => $result]);
    }
}
