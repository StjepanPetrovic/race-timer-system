# Kubernetes Deployment Guide

This directory contains all Kubernetes configurations for deploying the application.

## Directory Structure
- `deployments/` - Contains all deployment configurations
- `services/` - Contains all service configurations
- `config/` - Contains ConfigMaps and Secrets

## Deployment Steps

1. Build the Docker image:
```bash
docker build -t stjepan11/race-timer-api:latest -f kubernetes/Dockerfile .
docker push stjepan11/race-timer-api:latest
```