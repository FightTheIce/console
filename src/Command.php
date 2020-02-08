<?php

namespace FightTheIce\Console;

use FightTheIce\Console\Events\AfterCommand;
use FightTheIce\Console\Events\BeforeCommand;
use Illuminate\Console\Command as I_Command;
use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class Command extends I_Command {
    /**
     * @var mixed
     */
    protected $enabled = true;
    /**
     * @var mixed
     */
    protected $useEvents = true;
    /**
     * @var mixed
     */
    private $definition;

    /**
     * Write a string as error output.
     *
     * @param  string  $string
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function errorExit($message, $exit = false) {
        $this->output->writeln('<error>' . $message . '</error>', $this->parseVerbosity(null));

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\ErrorExit($message, $exit, $this));
        }

        if ($exit == true) {
            exit;
        }
    }

    /**
     * title
     * Setup a command title
     *
     * @access public
     * @param  string $title
     */
    public function title($message) {
        $this->output->title($message);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Title($message, $this));
        }
    }

    /**
     * section
     * Setup section text
     * @param  string $text
     */
    public function section($message) {
        $this->output->section($message);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Section($message, $this));
        }
    }

    /**
     * text
     * Output some text
     *
     * @access public
     * @param  string $message
     */
    public function text($message) {
        $this->output->text($message);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Text($message, $this));
        }
    }

    /**
     * listing
     * Output a listing
     *
     * @access public
     * @param  string $message
     */
    public function listing(array $elements) {
        $this->output->listing($elements);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Listing($elements, $this));
        }
    }

    /**
     * newLine
     * Output a new line (empty)
     *
     * @access public
     */
    public function newLine($count = 1) {
        $this->output->newLine($count);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\NewLine($count, $this));
        }
    }

    /**
     * note
     * Leave a note
     *
     * @access public
     * @param  string $message
     */
    public function note($message) {
        $this->output->note($message);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Note($message, $this));
        }
    }

    /**
     * caution
     * Output a caution note
     *
     * @access public
     * @param  string $message
     */
    public function caution($message) {
        $this->output->caution($message);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Caution($message, $this));
        }
    }

    /**
     * Success
     * Leave a success message
     *
     * @access public
     * @param  string $message
     */
    public function success($message) {
        $this->output->success($message);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Success($message, $this));
        }
    }

    /**
     * warning
     * Leave a warning note
     *
     * @access public
     * @param  string $message
     */
    public function warning($message) {
        $this->output->warning($message);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Warning($message, $this));
        }
    }

    /**
     * isEnabled
     * Is this command enabled
     *
     * @access public
     * @return boolean
     */
    public function isEnabled() {
        return $this->enabled;
    }

    /**
     * Confirm a question with the user.
     *
     * @param  string  $question
     * @param  bool    $default
     * @return bool
     */
    public function confirm($question, $default = false) {
        $confirm = parent::confirm($question, $default);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Input\Confirm($question, $default, $confirm, $this));
        }

        return $confirm;
    }

    /**
     * Prompt the user for input.
     *
     * @param  string  $question
     * @param  string  $default
     * @return string
     */
    public function ask($question, $default = null) {
        $ask = parent::ask($question, $default);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Input\Ask($question, $default, $ask, $this));
        }

        return $ask;
    }

    /**
     * Prompt the user for input with auto completion.
     *
     * @param  string  $question
     * @param  callable  $choices
     * @param  string|null  $default
     * @return mixed
     */
    public function anticipate($question, $choices, $default = null) {
        $anticipate = parent::askWithCompletion($question, $choices, $default);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Input\Anticipate($question, $choices, $default, $anticipate, $this));
        }

        return $anticipate;
    }

    /**
     * Prompt the user for input with auto completion.
     *
     * @param  string  $question
     * @param  array|callable  $choices
     * @param  string|null  $default
     * @return mixed
     */
    public function askWithCompletion($question, $choices, $default = null) {
        $askWithCompletion = parent::askWithCompletion($question, $choices, $default);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Input\AskWithCompletion($question, $choices, $default, $askWithCompletion, $this));
        }

        return $askWithCompletion;
    }

    /**
     * Prompt the user for input but hide the answer from the console.
     *
     * @param  string  $question
     * @param  bool    $fallback
     * @return string
     */
    public function secret($question, $fallback = true) {
        $secret = parent::secret($question, $fallback);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Input\Secret($question, $fallback, $secret, $this));
        }

        return $secret;
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
    public function choice($question, array $choices, $default = null, $attempts = null, $multiple = null) {
        $choice = parent::choice($question, $choices, $default, $attempts, $multiple);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Input\Choice($question, $choices, $default, $attempts, $multiple, $choice, $this));
        }

        return $choice;
    }

    /**
     * Format input to textual table.
     *
     * @param  array  $headers
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $rows
     * @param  string  $tableStyle
     * @param  array  $columnStyles
     * @return void
     */
    public function table($headers, $rows, $tableStyle = 'default', array $columnStyles = []) {
        parent::table($headers, $rows, $tableStyle, $columnStyles);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Table($headers, $rows, $columnStyles, $this));
        }
    }

    /**
     * Write a string as information output.
     *
     * @param  string  $string
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function info($string, $verbosity = null) {
        parent::line($string, $verbosity);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Info($string, $verbosity, $this));
        }
    }

    /**
     * Write a string as standard output.
     *
     * @param  string  $string
     * @param  string  $style
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function line($string, $style = null, $verbosity = null) {
        parent::line($string, $style, $verbosity);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Line($string, $style, $verbosity, $this));
        }
    }

    /**
     * Write a string as comment output.
     *
     * @param  string  $string
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function comment($string, $verbosity = null) {
        parent::line($string, 'comment', $verbosity);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Comment($string, $verbosity, $this));
        }
    }

    /**
     * Write a string as question output.
     *
     * @param  string  $string
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function question($string, $verbosity = null) {
        parent::line($string, 'question', $verbosity);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Question($string, $verbosity, $this));
        }
    }

    /**
     * Write a string as error output.
     *
     * @param  string  $string
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function error($string, $verbosity = null) {
        parent::line($string, 'error', $verbosity);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Error($string, $verbosity, $this));
        }
    }

    /**
     * Write a string as warning output.
     *
     * @param  string  $string
     * @param  null|int|string  $verbosity
     * @return void
     */
    public function warn($string, $verbosity = null) {
        if (!$this->output->getFormatter()->hasStyle('warning')) {
            $style = new OutputFormatterStyle('yellow');

            $this->output->getFormatter()->setStyle('warning', $style);
        }

        parent::line($string, 'warning', $verbosity);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Warn($string, $verbosity, $this));
        }
    }

    /**
     * Write a string in an alert box.
     *
     * @param  string  $string
     * @return void
     */
    public function alert($string) {
        parent::line(str_repeat('*', strlen($string) + 12), 'comment');
        parent::line('*     ' . $string . '     *');
        parent::line(str_repeat('*', strlen($string) + 12));
        $this->output->writeln('');

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new Events\Output\Alert($string, $this));
        }
    }

    /**
     * @return mixed
     */
    public function shouldUseEvents() {
        if (method_exists($this, 'useEvents') == true) {
            $val = $this->useEvents();

            if (is_bool($val)) {
                return $val;
            } else {
                if (is_bool($this->useEvents)) {
                    return $this->useEvents;
                } else {
                    return false;
                }
            }
        }

        if (is_bool($this->useEvents)) {
            return $this->useEvents;
        }

        return false;
    }

    /**
     * @param $val
     * @return mixed
     */
    public function setUseEvents($val) {
        if (is_bool($val)) {
            $this->useEvents = $val;
        }

        return $this;
    }

    /**
     * Run the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output) {
        $this->input  = $input;
        $this->output = $output;

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new BeforeCommand($this->input, $this->output, $this));
        }

        $value = parent::run($this->input, $this->output);

        if ($this->shouldUseEvents() == true) {
            $this->getApplication()->getEvents()->dispatch(new AfterCommand($this->input, $this->output, $this));
        }

        return $value;
    }
}
