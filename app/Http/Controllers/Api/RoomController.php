<?php

namespace App\Http\Controllers\Api;

use App\Entities\Message;
use App\Entities\Room;
use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoomResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $searches = $request->get('searches');

        /** @var User $user */
        $user = User::query()->where('id',auth()->id())->firstOrFail();
        /** @var Room $rooms */
        $rooms = $user->rooms()->with(['users','messagesAndUser'])->whereHas('messagesAndUser',function ($query) use ($searches){
                $query->where('message','ilike','%'.$searches.'%');
                $query->orWhereHas('users', function($query) use($searches){
                    $query->where('name','ilike','%'.$searches.'%');
                });
        })->get();

        return RoomResource::collection($rooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $attributes = $request->only(['message','user']);
        /** @var User $user */
        $user = User::query()->where('id', auth()->id())->firstOrFail();
        $remoteUser = User::query()->where('uuid', $attributes['user'])->firstOrFail();

        $search = $remoteUser->uuid;

        $room = $user->rooms()->with(['users'])->whereHas('users',function ($query) use ($search){
            $query->where('uuid',$search);
        })->first();

        if (is_null($room))
        {
            /** @var Room $roomCreate */
            $roomCreate = Room::query()->create(
                [
                    'name' => Str::random(10),
                    'group' => false,
                    'user_id' => auth()->id()
                ]
            );
            /** @var Room $room */
            $room = Room::query()->where('id',$roomCreate->id)->firstOrFail();

            $user->rooms()->attach($room);
            $remoteUser->rooms()->attach($room);

            $room->users()->attach($user);
            $room->users()->attach($remoteUser);
        }

        return response()->json($this->createMessage($attributes, $room->uuid));
    }

    public function messageStore(Request $request, $id)
    {
        $attributes = $request->only(['message']);

        return response()->json($this->createMessage($attributes, $id));
    }


    public function createMessage($attributes,$roomId)
    {
        /** @var Room $room */
        $room = Room::query()->where('uuid',$roomId)->firstOrFail();
        /** @var Message $message */
        $message = Message::query()->create(['message' => $attributes['message']]);
        $room->messages()->attach($message);

        /** @var User $user */
        $user = User::query()->where('id', auth()->id())->firstOrFail();
        $user->messages()->attach($message);
        $message->users()->attach($user);

        $rooms = $user->rooms()->with(['users','messagesAndUser'])->get();
        $roomResource = RoomResource::collection($rooms);

        broadcast(new ChatEvent($roomResource));

        return [
            'status' => 'message is sent successfuly!'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        //
    }
}
