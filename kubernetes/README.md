# Kubernetes Deployment Guide

This directory contains all Kubernetes configurations for deploying the application.

## Directory Structure
- `deployments/` - Contains all deployment configurations
- `services/` - Contains all service configurations
- `config/` - Contains ConfigMaps and Secrets

## Deployment Steps

1. Build the Docker image:
```bash
docker build -t your-registry/symfony-app:latest -f kubernetes/Dockerfile .
docker push stjepan11/symfony-app:latest
```