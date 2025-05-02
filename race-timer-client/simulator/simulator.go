// simulator/simulator.go
package simulator

import (
    "fmt"
    "math/rand"
    "racing-timer-client/api"
    "time"
)

type FinishLineSimulator struct {
    RaceID      int
    RunnerCount int
    Interval    time.Duration
}

func NewFinishLineSimulator(raceID, runnerCount int, interval time.Duration) *FinishLineSimulator {
    return &FinishLineSimulator{
        RaceID:      raceID,
        RunnerCount: runnerCount,
        Interval:    interval,
    }
}

func (s *FinishLineSimulator) Start() {
    fmt.Printf("Starting finish line simulation for race ID: %d\n", s.RaceID)
    
    // Create a slice of runner IDs that haven't finished yet
    remainingRunners := make([]int, s.RunnerCount)
    for i := 0; i < s.RunnerCount; i++ {
        remainingRunners[i] = i + 1
    }

    // Simulate runners finishing the race
    for len(remainingRunners) > 0 {
        // Randomly select a runner to finish
        index := rand.Intn(len(remainingRunners))
        runnerID := remainingRunners[index]
        
        // Remove the runner from remaining runners
        remainingRunners = append(remainingRunners[:index], remainingRunners[index+1:]...)

        // Send the result to the API
        finishTime := time.Now()
        err := api.SendRunnerResult(runnerID, s.RaceID, finishTime)
        if err != nil {
            fmt.Printf("Error sending result for runner %d: %v\n", runnerID, err)
            continue
        }

        fmt.Printf("Runner %d crossed the finish line at %v\n", runnerID, finishTime.Format("15:04:05.000"))

        // Wait for the specified interval before the next runner
        if len(remainingRunners) > 0 {
            time.Sleep(s.Interval)
        }
    }

    fmt.Println("Race finished! All runners have crossed the finish line.")
}