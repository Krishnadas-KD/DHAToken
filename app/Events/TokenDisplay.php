<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Counter;
use App\Models\CounterService;
use App\Models\TokenDetails;

class TokenDisplay implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $message)
    {
        
        $this->message = $message;
        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('token.display');
    }
    
    public function broadcastAs()
    {
        return 'display';
    }


    public function broadcastWith()
    {

        $service='Registration';
        $section='MALE';
        $status='Pending Registration';
        try{
            $tokenStatus = CounterService::select('counters.counter_name', 'token_workflows.token_name', 'token_workflows.section')
            ->join('counters', 'counters.id', '=', 'counter_services.counter_id')
            ->leftJoin('token_workflows', function ($join) use ($service, $section) {
                $join->on('token_workflows.counter_number', '=', 'counters.counter_number')
                    ->where('token_workflows.is_closed', 0)
                    ->where('token_workflows.status', 'In ' . $service);
            })
            ->join('services', 'services.id', '=', 'counter_services.service_id')
            ->where('services.service_name', $service)
            ->where('counters.counter_section', $section)
            ->distinct()
            ->orderBy('counters.counter_name')
            ->get();

            $pendingToken = TokenDetails::select('token_name', 'type', 'section', 'token_status', 'created_at')
            ->selectRaw('COALESCE((SELECT MAX(created_at) FROM token_workflows WHERE token_id = token_details.id), created_at) AS last_updated')
            ->where('section', '=', $section)
            ->where('token_status', '=', $status)
            ->where('closed', '=', '0')
            ->where('is_printed', 1)
            ->orderBy('last_updated', 'asc')
            ->orderBy('token_name', 'asc')
            ->take(40)
            ->get();
    }
    catch (Exception $e) {
        return [
            'error'=>$e
        ];
    }

        return [
            'pendingToken'=>$pendingToken,
            'tokenStatus'=>$tokenStatus
        ];
    }
}
