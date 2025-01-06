<?php

namespace App\Observers;

use App\Models\Interviews;
use App\Models\InterviewResults;
use App\Models\JobCandidates;

class InterviewObserver
{
    /**
     * Handle the Interviews "created" event.
     */
    public function created(Interviews $interview)
    {
        // Find the candidate details from the job_candidates table
        $candidate = JobCandidates::where('candidate_id', $interview->candidate_id)->first();

        // Automatically create a new record in InterviewResults
        InterviewResults::updateOrCreate(
            ['interview_id' => $interview->interview_id],
            [
                'candidate_id' => $interview->candidate_id,
                'candidate_name' => $interview->candidate_name,
                'applied_job' => $interview->applied_job,
                'interview_mode' => $interview->interview_mode,
                'email' => $interview->email,
                'phone' => $interview->phone,
                'interview_date' => $interview->interview_date,
                'resume_cv' => $candidate ? $candidate->candidate_resume : null, // Add candidate resume
                'cover_letter' => $candidate ? $candidate->candidate_cover_letter : null, // Add candidate cover letter
            ]
        );
    }

    /**
     * Handle the Interviews "updated" event.
     */
    public function updated(Interviews $interview)
    {
        // Find the candidate details from the job_candidates table
        $candidate = JobCandidates::where('candidate_id', $interview->candidate_id)->first();

        // Automatically update the corresponding record in InterviewResults
        InterviewResults::updateOrCreate(
            ['interview_id' => $interview->interview_id],
            [
                'candidate_id' => $interview->candidate_id,
                'candidate_name' => $interview->candidate_name,
                'applied_job' => $interview->applied_job,
                'interview_mode' => $interview->interview_mode,
                'email' => $interview->email,
                'phone' => $interview->phone,
                'interview_date' => $interview->interview_date,
                'resume_cv' => $candidate ? $candidate->candidate_resume : null, // Add candidate resume
                'cover_letter' => $candidate ? $candidate->candidate_cover_letter : null, // Add candidate cover letter
            ]
        );
    }

    /**
     * Handle the Interviews "deleted" event.
     */
    public function deleted(Interviews $interviews): void
    {
        //
    }

    /**
     * Handle the Interviews "restored" event.
     */
    public function restored(Interviews $interviews): void
    {
        //
    }

    /**
     * Handle the Interviews "force deleted" event.
     */
    public function forceDeleted(Interviews $interviews): void
    {
        //
    }
}
