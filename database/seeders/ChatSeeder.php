<?php

namespace Database\Seeders;

use App\Entities\Message;
use App\Entities\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $user */
        $user = User::query()->where('email','admin@admin.com')->firstOrFail();
        /** @var User $tester */
        $tester = User::query()->where('email','test@test.com')->firstOrFail();

        /** Test Odası */
        $rooms = [
            [
                'name' => 'TestRoom'
            ],
        ];

        foreach ($rooms as $key => $value) {
            Room::query()->updateOrCreate(
                [
                    'name' => $value['name']
                ],
                [
                    'group' => false,
                    'user_id' => $user->id
                ]
            );
        }

        /** Test Mesajları */
        $messages = [
            [
                'message' => 'Deneme Mesajı'
            ],
        ];

        foreach ($messages as $key => $value) {
            Message::query()->updateOrCreate(
                ['message' => $value['message']]
            );
        }

        /** @var Room $testRoom */
        $testRoom = Room::query()->where('name','TestRoom')->firstOrFail();
        $testRoom->messages()->attach(Message::all());

        $user->contacts()->attach($tester);

        //1.ve 2.useri odayla bağlantısını gerçekleştirdim
        $user->rooms()->attach($testRoom);
        $tester->rooms()->attach($testRoom);

        //1.usere mesajları atadım
        $user->messages()->attach(Message::all());
        /** @var Message $messages */
        $messages = Message::query()->first();
        $messages->users()->attach($user);

        //odadaki userların bağlantılarını gerçekleştirdim
        $testRoom->users()->attach($user);
        $testRoom->users()->attach($tester);
    }
}
