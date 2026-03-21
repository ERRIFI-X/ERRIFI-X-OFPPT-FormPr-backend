<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Participant;
use App\Models\Session;
use App\Models\Theme;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getStats(Request $request)
    {
        $user = auth()->user();
        
        $formationsQuery = Formation::query();
        $sessionsQuery = Session::query();
        $themesQuery = Theme::query();
        $participantsQuery = Participant::where('role', 'participant');

        if ($user->isCdc()) {
            $formationsQuery->where('cdc_id', $user->id);
            $sessionsQuery->whereHas('formation', function($q) use ($user) {
                $q->where('cdc_id', $user->id);
            });
            $themesQuery->whereHas('formation', function($q) use ($user) {
                $q->where('cdc_id', $user->id);
            });
            $participantsQuery->whereHas('theme.formation', function($q) use ($user) {
                $q->where('cdc_id', $user->id);
            });
        } elseif ($user->isFormateur()) {
            $formationsQuery->whereHas('formateurs', function($q) use ($user) {
                $q->where('users.id', $user->id);
            });
            $sessionsQuery->whereHas('formation.formateurs', function($q) use ($user) {
                $q->where('users.id', $user->id);
            });
            $themesQuery->whereHas('formation.formateurs', function($q) use ($user) {
                $q->where('users.id', $user->id);
            });
            $participantsQuery->whereHas('theme.formation.formateurs', function($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }

        $formationsCount = $formationsQuery->count();
        $sessionsCount = $sessionsQuery->count();
        $participantsCount = $participantsQuery->count();
        $totalHours = $themesQuery->sum('duration');

        // Recent stats/activities
        $recentActivities = [
            ['type' => 'formation', 'text' => 'Formations actives: ' . $formationsCount, 'time' => 'Maintenant', 'icon' => 'BookOpen'],
            ['type' => 'participant', 'text' => $participantsCount . ' Experts assignés', 'time' => 'Total', 'icon' => 'Users'],
            ['type' => 'session', 'text' => $sessionsCount . ' Sessions planifiées', 'time' => 'Total', 'icon' => 'Activity'],
        ];

        // Weekly activity (sessions per day for the last 7 days)
        $weeklyActivity = [];
        $days = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayName = $date->translatedFormat('D');
            
            // Map full/long day names to short version if needed, or just use Carbon
            $count = Session::whereDate('date', $date->format('Y-m-d'))->count();
            
            $weeklyActivity[] = [
                'day' => $days[$date->dayOfWeekIso - 1],
                'count' => $count
            ];
        }

        return response()->json([
            'stats' => [
                'formations' => $formationsCount,
                'participants' => $participantsCount,
                'sessions' => $sessionsCount,
                'total_hours' => $totalHours,
            ],
            'recent_activities' => $recentActivities,
            'weekly_activity' => $weeklyActivity
        ]);
    }
}
