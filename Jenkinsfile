#!groovy
pipeline {
    stages {
        stage('Build') {
            steps {
                // Your build steps go here
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
