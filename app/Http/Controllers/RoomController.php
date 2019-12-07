<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    private $roomModel;

    public function __construct(Room $roomModel)
    {
        $this->roomModel = $roomModel;
    }

    public function joinRoom(string $roomId) {
        if ($this->roomModel->where('room_id', $roomId)->count() !== 1) return redirect(route('index'));
        return view('room/index');
    }

    public function createRoom() {
        if ($this->roomModel->where('room_id', session('room_id'))->count() === 1) return view('room/lobby');

        $roomId = $this->createRoomId();
        $this->roomModel->create(['room_id' => $roomId]);
        session(['room_id' => $roomId]);

        return view('room/lobby');
    }

    public function startGame() {
        if ($this->roomModel->where('room_id', session('room_id'))->count() !== 1) return redirect(route('index'));
        return view('room/number');
    }

    private function createRoomId(): string {
        return uniqid('', true);
    }
}
