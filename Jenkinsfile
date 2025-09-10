pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'php-image'
        ECR_REPO = '461958693942.dkr.ecr.us-east-2.amazonaws.com/php-image'
        AWS_REGION = 'us-east-2'
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/vihaanyadav19/php-project.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    sh 'docker build -t $DOCKER_IMAGE .'
                }
            }
        }

        stage('Login to ECR') {
            steps {
                script {
                    sh '''
                    aws ecr get-login-password --region $AWS_REGION | docker login --username AWS --password-stdin $ECR_REPO
                    '''
                }
            }
        }

        stage('Push to ECR') {
            steps {
                script {
                    sh '''
                    docker tag $DOCKER_IMAGE:latest $ECR_REPO:latest
                    docker push $ECR_REPO:latest
                    '''
                }
            }
        }

        stage('Deploy on EC2') {
            steps {
                echo "Deployment on EC2: Pull Docker image from ECR and run"
                script {
                    sh '''
                    ssh -o StrictHostKeyChecking=no ubuntu@3.17.39.107 "docker pull $ECR_REPO:latest && docker stop php-crud-app || true && docker rm php-image || true && docker run -d --name php-image -p 3000:80 $ECR_REPO:latest"
                    '''
                }
            }
        }
    }
}

