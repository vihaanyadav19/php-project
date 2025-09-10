pipeline {
    agent any

    environment {
        DOCKER_IMAGE = 'php-crud-app'
        ECR_REPO = '170974506713.dkr.ecr.eu-north-1.amazonaws.com/php-crud-app'
        AWS_REGION = 'eu-north-1'
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/lavkeshBhadauriya98/php-crud-docker.git'
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
                    ssh -o StrictHostKeyChecking=no ubuntu@<EC2-PUBLIC-IP> "docker pull $ECR_REPO:latest && docker stop php-crud-app || true && docker rm php-crud-app || true && docker run -d --name php-crud-app -p 80:80 $ECR_REPO:latest"
                    '''
                }
            }
        }
    }
}

