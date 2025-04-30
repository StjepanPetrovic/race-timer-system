package api

// Runner struct represents a runner in the racing application
type Runner struct {
	ID          int    `json:"id"`
	Name        string `json:"name"`
	Surname     string `json:"surname"`
	StartNumber int    `json:"start_number"`
}