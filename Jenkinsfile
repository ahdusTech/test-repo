#!groovy
pipeline {
    stages {
        stage('Build') {
            steps {
                phpSyntaxCheck '**/*.php'
            }
        }
    }
    post {
        always {
            script {
                if (currentBuild.result == 'FAILURE') {
                    error "Build failed with exit code: ${currentBuild.result}"
                }
            }
        }
    }
}
