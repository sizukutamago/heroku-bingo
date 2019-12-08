<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    private $roomModel;

    private $participantModel;

    public function __construct(Room $roomModel, Participant $participantModel)
    {
        $this->roomModel = $roomModel;
        $this->participantModel = $participantModel;
    }

    public function participantLobby(string $roomId) {
        if ($this->roomModel->where('room_id', $roomId)->count() !== 1) return redirect(route('index'));
        return view('room/participantLobby', ['roomId' => $roomId]);
    }

    public function createUser(Request $request, string $roomId) {
        $room = $this->roomModel->where('room_id', $roomId)->get()->first();
        if (is_null($room)) return redirect(route('index'));

        $this->participantModel->create(['username' => $request->username, 'room_id' => $room->id]);
        session(['username' => $request->username]);
        return redirect(route('room', $roomId));
    }

    public function joinRoom(string $roomId) {
        if ($this->roomModel->where('room_id', $roomId)->count() !== 1) return redirect(route('index'));
        // todo: usernameとroomidでwhereして存在しなければリダイレクト
        return view('room/index');
    }

    public function createRoom() {
        if ($this->roomModel->where('room_id', session('room_id'))->count() === 1) return view('room/confirm');

        $this->create();
        return view('room/lobby');
    }

    public function forceCreateRoom() {
        $this->create();
        return view('room/lobby');
    }

    public function startGame() {
        if ($this->roomModel->where('room_id', session('room_id'))->count() !== 1) return redirect(route('index'));
        return view('room/number');
    }

    private function createRoomId(): string {
        return uniqid('', true);
    }

    private function create() {
        $roomId = $this->createRoomId();
        $this->roomModel->create(['room_id' => $roomId]);
        session(['room_id' => $roomId]);
    }
}
