pipeline {
  agent any

  stages {
    stage('Build') {
      steps {
        // Run PHP lint to check for syntax errors
        sh 'php -l .'
      }
    }
  }

  post {
    always {
      // Check the exit code of the previous step
      if (currentBuild.result == 'FAILURE') {
        // Stop the build if there were errors
        error 'There were errors in the PHP code. Stopping the build.'
      }
    }
  }
}
