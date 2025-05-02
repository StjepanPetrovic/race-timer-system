package main

import (
    "fmt"
    "math/rand"
    "racing-timer-client/simulator"
    "time"
)


func main() {
     // Set random seed
     rand.Seed(time.Now().UnixNano())

     fmt.Println("Racing Timer Client - Finish Line Simulator")

     // Configuration
     raceID := 1 // Set your race ID
     runnerCount := 10 // Number of runners in the race

     // Random interval between runners (between 2 and 5 seconds)
     minInterval := 2 * time.Second
     maxInterval := 5 * time.Second
     averageInterval := (maxInterval - minInterval) / 2 + minInterval

     // Create and start the simulator
     sim := simulator.NewFinishLineSimulator(raceID, runnerCount, averageInterval)
     sim.Start()
 }
