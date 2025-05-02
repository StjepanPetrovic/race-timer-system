package api

import (
    "bytes"
    "encoding/json"
    "fmt"
    "net/http"
    "time"
)

// Runner struct represents a runner in the racing application
type ResultRequest struct {
    StartNumber int       `json:"start_number"`  // Changed from RunnerId to StartNumber
    RaceId      int       `json:"race_id"`
    Time        time.Time `json:"time"`
}

// Base URL of the Symfony API
const baseURL = "https://127.0.0.1:8000/api"

// SendRunnerResult sends a runner's finish time to the API
func SendRunnerResult(startNumber int, raceId int, finishTime time.Time) error {
    result := ResultRequest{
        StartNumber: startNumber,
        RaceId:   raceId,
        Time:     finishTime,
    }

    jsonData, err := json.Marshal(result)
    if err != nil {
        return fmt.Errorf("error marshaling result: %v", err)
    }

    url := fmt.Sprintf("%s/finish-line", baseURL)
    req, err := http.NewRequest("POST", url, bytes.NewBuffer(jsonData))
    if err != nil {
        return fmt.Errorf("error creating request: %v", err)
    }

    req.Header.Set("Content-Type", "application/json")

    client := &http.Client{}
    resp, err := client.Do(req)
    if err != nil {
        return fmt.Errorf("error sending request: %v", err)
    }
    defer resp.Body.Close()

    if resp.StatusCode != http.StatusOK && resp.StatusCode != http.StatusCreated {
        return fmt.Errorf("unexpected status code: %d", resp.StatusCode)
    }

    return nil
}
