package api

import (
    "bytes"
    "encoding/json"
    "fmt"
    "net/http"
    "time"
    "io"
)

// Runner struct represents a runner in the racing application
type ResultRequest struct {
    StartNumber int       `json:"start_number"`  // Changed from RunnerId to StartNumber
    RaceId      int       `json:"race_id"`
    Time        time.Time `json:"time"`
}

// Base URL of the Symfony API
// const baseURL = "https://127.0.0.1:8000/api"
const baseURL = "http://localhost:8080/api"

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
        body, err := io.ReadAll(resp.Body)
        if err != nil {
            return fmt.Errorf("status code: %d, error reading response body: %v", resp.StatusCode, err)
        }
        return fmt.Errorf("status code: %d, response body: %s", resp.StatusCode, string(body))
    }

    return nil
}
