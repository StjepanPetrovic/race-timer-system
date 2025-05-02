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
     raceID := 6 // Set your race ID

     // Define start numbers for the race
     startNumbers := []int{101, 102, 103, 104, 105, 106, 107, 108, 109, 110}

     // Random interval between runners (between 2 and 5 seconds)
     interval := 2 * time.Second

     // Create and start the simulator
     sim := simulator.NewFinishLineSimulator(raceID, startNumbers, interval)
     sim.Start()
 }
