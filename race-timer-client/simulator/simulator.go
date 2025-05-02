// simulator/simulator.go
package simulator

import (
    "fmt"
    "math/rand"
    "racing-timer-client/api"
    "time"
)

type Runner struct {
    StartNumber int
}


type FinishLineSimulator struct {
    RaceID      int
    StartNumbers   []int    // Array of start numbers in the race
    Interval    time.Duration
}

func NewFinishLineSimulator(raceID int, startNumbers []int, interval time.Duration) *FinishLineSimulator {
    return &FinishLineSimulator{
        RaceID:      raceID,
        StartNumbers: startNumbers,
        Interval:    interval,
    }
}

func (s *FinishLineSimulator) Start() {
    fmt.Printf("Starting finish line simulation for race ID: %d\n", s.RaceID)
    fmt.Printf("Registered start numbers: %v\n", s.StartNumbers)

    // Create a copy of start numbers to track remaining runners
    remainingRunners := make([]int, len(s.StartNumbers))
    copy(remainingRunners, s.StartNumbers)

    // Simulate runners finishing the race
    for len(remainingRunners) > 0 {
        // Randomly select a runner to finish
        index := rand.Intn(len(remainingRunners))
        startNumber := remainingRunners[index]
        
        // Remove the runner from remaining runners
        remainingRunners = append(remainingRunners[:index], remainingRunners[index+1:]...)

        // Send the result to the API
        finishTime := time.Now()
        err := api.SendRunnerResult(startNumber, s.RaceID, finishTime)
        if err != nil {
            fmt.Printf("Error sending result for runner %d: %v\n", startNumber, err)
            continue
        }

        fmt.Printf("Runner %d crossed the finish line at %v\n", startNumber, finishTime.Format("15:04:05.000"))

        // Wait for the specified interval before the next runner
        if len(remainingRunners) > 0 {
            time.Sleep(s.Interval)
        }
    }

    fmt.Println("Race finished! All runners have crossed the finish line.")
}