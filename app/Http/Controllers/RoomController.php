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
        if (session($roomId . '_username')) return redirect(route('room', $roomId));
        return view('room/participantLobby', ['roomId' => $roomId]);
    }

    public function createUser(Request $request, string $roomId) {
        $room = $this->roomModel->where('room_id', $roomId)->get()->first();
        if (is_null($room)) return redirect(route('index'));
        $participant = $this->participantModel->where('room_id', $room->id)->where('username', $request->username)->get()->first();
        if (!is_null($participant)) {
            return redirect(route('participantLobby', ['roomId' => $roomId]))->with('error', 'このニックネームはすでに使われています。');
        }
        // todo: ユーザ一覧とかの管理画面作る
        $this->participantModel->create(['username' => $request->username, 'room_id' => $room->id]);
        session([$roomId . '_username' => $request->username]);
        return redirect(route('room', $roomId));
    }

    public function joinRoom(string $roomId) {
        $username = session($roomId . '_username');
        if (!$username) return redirect(route('participantLobby', ['roomId' => $roomId]));
        $room = $this->roomModel->where('room_id', $roomId)->get()->first();
        if (!$room) return redirect(route('index'));
        if ($this->participantModel->where('room_id', $room->id)->where('username', $username)->count() !== 1) return redirect(route('index'));

        return view('room/index', compact('roomId', 'username'));
    }

    public function createRoom() {
        if ($this->roomModel->where('room_id', session('room_id'))->count() === 1) return view('room/confirm');

        $this->create();
        return view('room/lobby');
    }

    public function returnRoom() {
        if ($this->roomModel->where('room_id', session('room_id'))->count() !== 1) return redirect(route('index'));

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

    public function reachNotification(Request $request, string $roomId) {
        $room = $this->roomModel->where('room_id', $roomId)->get()->first();
        if ($room === null) return ['status' => 401, 'message' => 'not found room'];
        $participant = $this->participantModel->where('room_id', $room->id)->where('username', $request->username)->get()->first();
        if ($participant === null) return ['status' => 401, 'message' => 'not found user'];
        $participant->is_reach = $request->isReach === 'true';
        $participant->save();
        return ['status' => 200, 'message' => 'OK'];
    }

    public function getParticipants(string $roomId) {
        $room = $this->roomModel->with('participants')->where('room_id', $roomId)->get()->first();
        if ($room === null) return [];
        return $room->participants;
    }

    private function createRoomId(): string {
        return uniqid('', true);
    }

    private function create(): void {
        $roomId = $this->createRoomId();
        $this->roomModel->create(['room_id' => $roomId]);
        session(['room_id' => $roomId]);
    }
}
