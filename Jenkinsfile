pipeline {
  agent any
  stages {
    stage('TESTS') {
      steps {
        sh 'php artisan dusk'
      }
    }
  }
}