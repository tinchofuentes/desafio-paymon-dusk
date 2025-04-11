<?php

namespace App\Services;

use App\Mail\CommunicationMail;
use App\Models\Communication;
use App\Models\Guardian;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CommunicationService
{
    /**
     * Sends a communication to guardians based on established criteria
     * 
     * @param Communication $communication
     * @return array Array with recipient count and errors
     */
    public function sendCommunication(Communication $communication): array
    {
        $guardianIds = $this->getFilteredGuardianIds($communication);
        
        $sent = 0;
        $errors = 0;
        
        if (count($guardianIds) > 0) {
            $communication->guardians()->sync($guardianIds);
            
            foreach (Guardian::whereIn('id', $guardianIds)->get() as $guardian) {
                try {
                    Mail::to($guardian->email)
                        ->queue(new CommunicationMail($communication, $guardian));
                    $sent++;
                } catch (\Exception $e) {
                    Log::error("Error enviando comunicado {$communication->id} a {$guardian->email}: " . $e->getMessage());
                    $errors++;
                }
            }
        }
        
        return [
            'total' => count($guardianIds),
            'sent' => $sent,
            'errors' => $errors
        ];
    }
    
    /**
     * Gets the IDs of guardians filtered according to the communication criteria
     * 
     * @param Communication $communication
     * @return array Array of guardian IDs
     */
    public function getFilteredGuardianIds(Communication $communication): array
    {
        $studentsQuery = Student::query();
        
        if ($communication->course_id) {
            $studentsQuery->whereHas('enrollments', function ($query) use ($communication) {
                $query->where('course_id', $communication->course_id);
            });
        }
        
        if ($communication->age_from) {
            $maxBirthDate = Carbon::now()->subYears($communication->age_from);
            $studentsQuery->where('birth_date', '<=', $maxBirthDate);
        }
        
        if ($communication->age_to) {
            $minBirthDate = Carbon::now()->subYears($communication->age_to + 1)->addDay();
            $studentsQuery->where('birth_date', '>=', $minBirthDate);
        }
        
        return $studentsQuery->pluck('guardian_id')->unique()->values()->toArray();
    }
} 