<?php

namespace FightTheIce\Console;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class Screen
{
    protected $input   = null;
    protected $output  = null;
    protected $monolog = null;

    protected $level      = null;
    protected $message    = null;
    protected $subsection = null;
    protected $context    = null;

    protected $symfonyStyle = null;

    /**
     * The default verbosity of output commands.
     *
     * @var int
     */
    protected $verbosity = OutputInterface::VERBOSITY_NORMAL;

    /**
     * The mapping between human readable verbosity levels and Symfony's OutputInterface.
     *
     * @var array
     */
    protected $verbosityMap = [
        'v'      => OutputInterface::VERBOSITY_VERBOSE,
        'vv'     => OutputInterface::VERBOSITY_VERY_VERBOSE,
        'vvv'    => OutputInterface::VERBOSITY_DEBUG,
        'quiet'  => OutputInterface::VERBOSITY_QUIET,
        'normal' => OutputInterface::VERBOSITY_NORMAL,
    ];

    public function __construct(InputInterface $input, OutputInterface $output, $monolog = null)
    {
        $this->input  = $input;
        $this->output = $output;

        $this->monolog = $monolog;
    }

    protected function reset()
    {
        $this->level      = null;
        $this->message    = null;
        $this->subsection = null;
        $this->context    = null;

        return $this;
    }

    /**
     * Get the verbosity level in terms of Symfony's OutputInterface level.
     *
     * @param  string|int  $level
     * @return int
     */
    protected function parseVerbosity($level = null)
    {
        if (isset($this->verbosityMap[$level])) {
            $level = $this->verbosityMap[$level];
        } elseif (!is_int($level)) {
            $level = $this->verbosity;
        }

        return $level;
    }

    protected function dispatchToMonolog()
    {
        if (is_null($this->level)) {
            $this->reset();
            return;
        }

        if (!is_null($this->monolog)) {
            if (!is_array($this->context)) {
                if (is_null($this->context)) {
                    $this->context = array();
                } else {
                    $tmp[]         = $this->context;
                    $this->context = $tmp;
                }
            }

            call_user_func_array(array($this->monolog, $this->level), array('[' . $this->subsection . '] ' . $this->message, $this->context));
        }

        $this->reset();

        return $this;
    }

    protected function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    protected function setupSymfonyStyle()
    {
        if (is_null($this->symfonyStyle)) {
            $this->symfonyStyle = new SymfonyStyle($this->input, $this->output);
        }

        return $this;
    }

    public function debug()
    {
        return $this->setLevel('debug');
    }

    public function info()
    {
        return $this->setLevel('info');
    }

    public function notice()
    {
        return $this->setLevel('notice');
    }

    public function warning()
    {
        return $this->setLevel('warning');
    }

    public function error()
    {
        return $this->setLevel('error');
    }

    public function critical()
    {
        return $this->setLevel('critical');
    }

    public function alert()
    {
        return $this->setLevel('alert');
    }

    public function emergency()
    {
        return $this->setLevel('emergency');
    }

    /** title
     * Setup a command title
     *
     * @access public
     * @param  string $title
     */
    public function title($title = '')
    {
        $this->setupSymfonyStyle();
        $this->symfonyStyle->title($title);

        $this->message    = $title;
        $this->subsection = __FUNCTION__;

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * section
     * Setup section text
     * @param  string $text
     */
    public function section($message = '')
    {
        $this->setupSymfonyStyle();
        $this->symfonyStyle->section($message);

        $this->message    = $message;
        $this->subsection = __FUNCTION__;

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * text
     * Output some text
     *
     * @access public
     * @param  string $message
     */
    public function text($message)
    {
        $this->setupSymfonyStyle();
        $this->symfonyStyle->text($message);

        $this->message    = $message;
        $this->subsection = __FUNCTION__;

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * listing
     * Output a listing
     *
     * @access public
     * @param  string $message
     */
    public function listing($message)
    {
        $this->setupSymfonyStyle();
        $this->symfonyStyle->listing($message);

        $this->message    = $message;
        $this->subsection = __FUNCTION__;

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * newLine
     * Output a new line (empty)
     *
     * @access public
     */
    public function newLine()
    {
        $this->setupSymfonyStyle();
        $this->symfonyStyle->newLine();

        $this->message    = '';
        $this->subsection = __FUNCTION__;

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * note
     * Leave a note
     *
     * @access public
     * @param  string $message
     */
    public function note($message)
    {
        $this->setupSymfonyStyle();
        $this->symfonyStyle->note($message);

        $this->message    = $message;
        $this->subsection = __FUNCTION__;

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * caution
     * Output a caution note
     *
     * @access public
     * @param  string $message
     */
    public function caution($message)
    {
        $this->setupSymfonyStyle();

        $this->symfonyStyle->caution($message);

        $this->message    = $message;
        $this->subsection = __FUNCTION__;

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * Success
     * Leave a success message
     *
     * @access public
     * @param  string $message
     */
    public function success($message)
    {
        $this->setupSymfonyStyle();
        $this->symfonyStyle->success($message);

        $this->message    = $message;
        $this->subsection = __FUNCTION__;

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * warning
     * Leave a warning note
     *
     * @access public
     * @param  string $message
     */
    public function warningmsg($message)
    {
        $this->setupSymfonyStyle();
        $this->symfonyStyle->warning($message);

        $this->message    = $message;
        $this->subsection = __FUNCTION__;

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * Confirm a question with the user.
     *
     * @param  string  $question
     * @param  bool    $default
     * @return bool
     */
    public function confirm($question, $default = false)
    {

        //return $this->output->confirm($question, $default);
        $confirmation = $this->output->confirm($question, $default);

        $this->message    = $question;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'     => 'confirm',
            'question' => $question,
            'default'  => $default,
            'response' => $confirmation,
        );

        $this->dispatchToMonolog();

        return $confirmation;
    }

    /**
     * Prompt the user for input.
     *
     * @param  string  $question
     * @param  string  $default
     * @return string
     */
    public function ask($question, $default = null)
    {
        $ask = $this->output->ask($question, $default);

        $this->message    = $question;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'     => 'ask',
            'question' => $question,
            'default'  => $default,
            'response' => $ask,
        );

        $this->dispatchToMonolog();

        return $ask;
    }

    /**
     * Prompt the user for input with auto completion.
     *
     * @param  string  $question
     * @param  array   $choices
     * @param  string  $default
     * @return string
     */
    public function anticipate($question, array $choices, $default = null)
    {
        $anti = $this->askWithCompletion($question, $choices, $default);

        $this->message    = $question;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'     => __FUNCTION__,
            'question' => $question,
            'choices'  => $choices,
            'default'  => $default,
            'response' => $confirmation,
        );

        $this->dispatchToMonolog();

        return $anti;
    }

    /**
     * Prompt the user for input with auto completion.
     *
     * @param  string  $question
     * @param  array   $choices
     * @param  string  $default
     * @return string
     */
    public function askWithCompletion($question, array $choices, $default = null)
    {
        $question = new Question($question, $default);

        $question->setAutocompleterValues($choices);

        $qst = $this->output->askQuestion($question);

        $this->message    = $question;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'     => 'askWithCompletion',
            'question' => $question,
            'choices'  => $choices,
            'default'  => $default,
            'response' => $qst,
            'options'  => array(
                'setAutocompleterValues',
            ),
        );

        $this->dispatchToMonolog();

        return $qst;
    }

    /**
     * Prompt the user for input but hide the answer from the console.
     *
     * @param  string  $question
     * @param  bool    $fallback
     * @return string
     */
    public function secret($question, $fallback = true)
    {
        $question = new Question($question);

        $question->setHidden(true)->setHiddenFallback($fallback);

        $qst = $this->output->askQuestion($question);

        $this->message    = $question;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'     => 'secret',
            'question' => $question,
            'choices'  => $choices,
            'default'  => $default,
            'response' => $qst,
            'options'  => array(
                'setHidden',
                'setHiddenFallback',
            ),
        );

        $this->dispatchToMonolog();

        return $qst;
    }

    /**
     * Give the user a single choice from an array of answers.
     *
     * @param  string  $question
     * @param  array   $choices
     * @param  string  $default
     * @param  mixed   $attempts
     * @param  bool    $multiple
     * @return string
     */
    public function choice($question, array $choices, $default = null, $attempts = null, $multiple = null)
    {
        $question = new ChoiceQuestion($question, $choices, $default);

        $question->setMaxAttempts($attempts)->setMultiselect($multiple);

        $qst = $this->output->askQuestion($question);

        $this->message    = $question;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'     => __FUNCTION__,
            'question' => $question,
            'choices'  => $choices,
            'default'  => $default,
            'response' => $qst,
            'options'  => array(
                'setMaxAttempts',
                'setMultiselect',
            ),
        );

        $this->dispatchToMonolog();

        return $qst;
    }

    /**
     * Format input to textual table.
     *
     * @param  array   $headers
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $rows
     * @param  string  $style
     * @return void
     */
    public function table(array $headers, $rows, $style = 'default')
    {
        $table = new Table($this->output);

        if ($rows instanceof Arrayable) {
            $rows = $rows->toArray();
        }

        $table->setHeaders($headers)->setRows($rows)->setStyle($style)->render();
    }

    /**
     * Write a string as information output.
     *
     * @param  string  $string
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function infomsg($string, $verbosity = null)
    {
        $this->line($string, 'info', $verbosity);

        $this->message    = $string;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'      => 'infomsg',
            'data'      => $string,
            'verbosity' => $verbosity,
        );

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * Write a string as standard output.
     *
     * @param  string  $string
     * @param  string  $style
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function line($string, $style = null, $verbosity = null)
    {
        $styled = $style ? "<$style>$string</$style>" : $string;

        $this->output->writeln($styled, $this->parseVerbosity($verbosity));

        $this->message    = $string;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'      => 'line',
            'data'      => $string,
            'verbosity' => $verbosity,
            'style'     => $style,
        );

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * Write a string as comment output.
     *
     * @param  string  $string
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function comment($string, $verbosity = null)
    {
        $this->line($string, 'comment', $verbosity);

        $this->message    = $string;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'      => 'line',
            'data'      => $string,
            'verbosity' => $verbosity,
        );

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * Write a string as question output.
     *
     * @param  string  $string
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function question($string, $verbosity = null)
    {
        $this->line($string, 'question', $verbosity);

        $this->message    = $string;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'      => 'question',
            'data'      => $string,
            'verbosity' => $verbosity,
        );

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * Write a string as error output.
     *
     * @param  string  $string
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function errormsg($string, $verbosity = null)
    {
        $this->line($string, 'error', $verbosity);

        $this->message    = $string;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'      => 'error',
            'data'      => $string,
            'verbosity' => $verbosity,
        );

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * Write a string as warning output.
     *
     * @param  string  $string
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function warn($string, $verbosity = null)
    {
        if (!$this->output->getFormatter()->hasStyle('warning')) {
            $style = new OutputFormatterStyle('yellow');

            $this->output->getFormatter()->setStyle('warning', $style);
        }

        $this->line($string, 'warning', $verbosity);

        $this->message    = $string;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'      => 'warn',
            'data'      => $string,
            'verbosity' => $verbosity,
        );

        $this->dispatchToMonolog();

        return $this;
    }

    /**
     * Write a string in an alert box.
     *
     * @param  string  $string
     * @return void
     */
    public function alertmsg($string)
    {
        $this->comment(str_repeat('*', strlen($string) + 12));
        $this->comment('*     ' . $string . '     *');
        $this->comment(str_repeat('*', strlen($string) + 12));

        $this->output->writeln('');

        $this->message    = $string;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type' => 'alertmsg',
            'data' => $string,
        );

        $this->dispatchToMonolog();

        return $this;
    }

    public function writeToMonologOnly($message)
    {
        $this->level      = 'critical';
        $this->message    = $message;
        $this->subsection = __FUNCTION__;
        $this->context    = array(
            'type'    => __FUNCTION__,
            'message' => $message,
        );

        $this->dispatchToMonolog();
    }
}
