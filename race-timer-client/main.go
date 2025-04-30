package main

import (
	"fmt"
	"racing-timer-client/api"
)

func main() {
	fmt.Println("Racing Timer Client started.")

	// Example: Call a function from your API client
	runnerID := 1
	runner, err := api.GetRunner(runnerID)
	if err != nil {
		fmt.Printf("Error fetching runner: %v\n", err)
		return
	}

	fmt.Printf("Runner details: %+v\n", runner)
}
