<?php

namespace App\Observers;

use App\Models\JobCandidates;
use App\Models\Applications;

class JobCandidateObserver
{
    /**
     * Handle the JobCandidates "created" event.
     */
    public function created(JobCandidates $jobCandidates): void
    {
        //
    }

    /**
     * Handle the JobCandidates "updated" event.
     */
    public function updated(JobCandidates $jobCandidates): void
    {
       //
    }
    

    /**
     * Handle the JobCandidates "saved" event.
     *
     * @param  \App\Models\JobCandidates  $jobCandidate
     * @return void
     */
    public function saved(JobCandidates $jobCandidate)
    {
        // Retrieve the associated application based on application_id
        $application = Applications::where('application_id', $jobCandidate->application_id)->first();

        if ($application) {
            // Determine the application status based on candidate_status
            if ($jobCandidate->candidate_status === 'Qualified') {
                $applicationStatus = 'Approved';
            } elseif ($jobCandidate->candidate_status === 'Not Qualified') {
                $applicationStatus = 'Rejected';
            } else {
                return; // No update needed if the candidate_status doesn't match these values
            }

            // Update the application_status in the Applications table
            $application->application_status = $applicationStatus;
            $application->save();

            // Update the application_status in the JobCandidates table
            $jobCandidate->application_status = $applicationStatus;
            $jobCandidate->saveQuietly(); // Avoid triggering an infinite loop by using saveQuietly
        }
    }


    /**
     * Handle the JobCandidates "deleted" event.
     */
    public function deleted(JobCandidates $jobCandidates): void
    {
        //
    }

    /**
     * Handle the JobCandidates "restored" event.
     */
    public function restored(JobCandidates $jobCandidates): void
    {
        //
    }

    /**
     * Handle the JobCandidates "force deleted" event.
     */
    public function forceDeleted(JobCandidates $jobCandidates): void
    {
        //
    }
}
