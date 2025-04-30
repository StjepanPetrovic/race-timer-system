package api

import (
	"encoding/json"
	"fmt"
	"net/http"
)

// Base URL of the Symfony API
const baseURL = "http://127.0.0.1:8000"

// GetRunner fetches details of a runner from the Symfony API
func GetRunner(runnerID int) (*Runner, error) {
	url := fmt.Sprintf("%s/runners/%d", baseURL, runnerID)

	response, err := http.Get(url)
	if err != nil {
		return nil, err
	}
	defer response.Body.Close()

	// Decode the JSON response
	var runner Runner
	if err := json.NewDecoder(response.Body).Decode(&runner); err != nil {
		return nil, err
	}

	return &runner, nil
}
