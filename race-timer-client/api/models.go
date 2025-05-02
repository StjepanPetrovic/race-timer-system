package api

import "time"

// Runner struct represents a runner in the racing application
type ResultRequest struct {
    RunnerId int       `json:"runner_id"`
    RaceId   int       `json:"race_id"`
    Time     time.Time `json:"time"`
}
