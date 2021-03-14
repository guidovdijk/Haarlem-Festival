-<?php
    class head {
        private string $title;
        private string $class;

        public function __construct(string $title, string $class) {
            $this->title = $title;
            $this->class = $class;
        }

        public function render()
        {
            echo sprintf("
            <!DOCTYPE html>
            <html lang='en'>

            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='preconnect' href='https://fonts.gstatic.com'>
                <link
                    href='https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600;700&display=swap'
                    rel='stylesheet'>
                <link rel='stylesheet' href='/assets/styles/main.css'>
                <title>$this->title</title>
            </head>

            <body class='$this->class'>
            ");
        }
    }
?>
