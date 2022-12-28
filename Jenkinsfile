#!groovy
pipeline {
    stages {
        stage('Build') {
            steps {
                syntaxError '**/*.php'
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
