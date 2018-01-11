<?php

class SqlHandler
{
    public $file_handler;
    public $byte_user = 'root';
    public $byte_pass = '';
    public $byte_host = '127.0.0.1';

    public $sql_username = "root";
    public $sql_password = "";
    public $sql_hostname = "127.0.0.1";

    //////////////////////////////////////////////////////////
    //
    //                  Account
    //
    /////////////////////////////////////////////////////////

    public function add_account($username, $date_created, $last_log, $rank_id, $online, $reputation)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Bytesite');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Accounts (username, date_created, last_log, rank_id, online, reputation) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssiii', $username, $date_created, $last_log, $rank_id, $online, $reputation);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_account($name)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Bytesite');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Accounts WHERE username = ?');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->store_result();

        $accounts = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($account_id, $username, $date_created, $last_log, $rank_id, $online, $reputation);

            require_once(dirname(__FILE__) . '/sql/bytesite/Accounts.php');
            $accounts = new Accounts($account_id, $username, $date_created, $last_log, $rank_id, $online, $reputation);
        } else {
            return null;
        }

        $mysqli->close();

        if ($accounts != null) {
            return $accounts;
        }
    }

    public function get_account_using_id($account_id)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Bytesite');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Accounts WHERE account_id = ?');
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $stmt->store_result();

        $accounts = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($account_id, $username, $date_created, $last_log, $rank_id, $online, $reputation);

            while ($stmt->fetch()) {
                require_once(dirname(__FILE__) . '/sql/bytesite/Accounts.php');
                $accounts = new Accounts($account_id, $username, $date_created, $last_log, $rank_id, $online, $reputation);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($accounts != null) {
            return $accounts;
        }
    }

    public function update_account($account)
    {
        if ($account instanceof Accounts) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Bytesite');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Accounts SET username = ?, date_created = ?, last_log = ?, rank_id = ?, online = ?, reputation = ? WHERE account_id = ?');
            $stmt->bind_param('sssiiis', $account->username, $account->date_created, $account->last_log, $account->rank_id, $account->online, $account->reputation, $account->accounts_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save account!');
        }
    }

    public function delete_account($account)
    {
        if ($account instanceof Accounts) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Bytesite');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Accounts WHERE account_id = ?');
            $stmt->bind_param('i', $account->account_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete account');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Friends
    //
    /////////////////////////////////////////////////////////

    public function add_friend($friender_id, $friended_id, $friended_date)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Friends (friender_id, friended_id, friended_date) VALUES (?, ?, ?)');
        $stmt->bind_param('iis', $friender_id, $friended_id, $friended_date);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_friends($friend_id)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Friends WHERE friender_id = ? OR friended_id = ?');
        $stmt->bind_param('ii', $friend_id, $friend_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($friend_id, $friender_id, $friended_id, $friended_date);
            $friend = array();

            while ($stmt->fetch()) {
                require_once(dirname(__FILE__) . '/sql/social/Friends.php');
                array_push($friend, new Friends($friend_id, $friender_id, $friended_id, $friended_date));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($friend != null) {
            return $friend;
        }
    }

    public function update_friend($friend)
    {
        if ($friend instanceof Friends) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Friends SET friender_id = ?, friended_id = ?, friended_date = ? WHERE friend_id = ?');
            $stmt->bind_param('iisi', $friend->friender_id, $friend->friended_date, $friend->friended_date, $friend->friend_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save friend!');
        }
    }

    public function delete_friend($friend)
    {
        if ($friend instanceof Friends) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Friends WHERE friend_id = ?');
            $stmt->bind_param('i', $friend->friend_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete friend');
        }
    }
    //////////////////////////////////////////////////////////
    //
    //                  Instants
    //
    /////////////////////////////////////////////////////////

    public function add_instant($account_id, $friend_id, $message, $sent)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Instants (account_id, friend_id, message, sent) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('iiss', $account_id, $friend_id, $message, $sent);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_instants($user_id)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Instants WHERE friend_id = ? OR account_id = ?');
        $stmt->bind_param('ii', $user_id, $user_id);
        $stmt->execute();
        $stmt->store_result();

        $instant = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($instant_id, $account_id, $friend_id, $message, $sent);
            require_once(dirname(__FILE__) . '/sql/social/Instants.php');
            $instant = array();

            while ($stmt->fetch()) {
                array_push($instant, new Instants($instant_id, $account_id, $friend_id, $message, $sent));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($instant != null) {
            return $instant;
        }
    }

    public function update_instant($instant)
    {
        if ($instant instanceof Instants) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Instants SET account_id = ?, friend_id = ?, message = ?, sent = ? WHERE instant_id = ?');
            $stmt->bind_param('iissi', $instant->account_id, $instant->friend_id, $instant->message, $instant->sent, $instant->instant_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save instant!');
        }
    }

    public function delete_instant($instant)
    {
        if ($instant instanceof Instants) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Instants WHERE instant_id = ?');
            $stmt->bind_param('i', $instant->instant_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete instant');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Messages
    //
    /////////////////////////////////////////////////////////

    public function add_message($type, $account_id, $friend_id, $subject, $message, $sent)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Messages (type, account_id, friend_id, subject, message, sent) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('iiisss', $type, $account_id, $friend_id, $subject, $message, $sent);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_message($user_id)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Messages WHERE account_id = ? OR $friend_id = ?');
        $stmt->bind_param('ii', $user_id, $user_id);
        $stmt->execute();
        $stmt->store_result();

        $message = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($message_id, $type, $account_id, $friend_id, $subject, $message, $sent);

            while ($stmt->fetch()) {
                require_once(dirname(__FILE__) . '/sql/social/Messages.php');
                $message = new Messages($message_id, $type, $account_id, $friend_id, $subject, $message, $sent);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($message != null) {
            return $message;
        }
    }

    public function update_message($message)
    {
        if ($message instanceof Messages) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Messages SET type = ?, account_id = ?, $friend_id = ?, subject = ?, message = ?, sent = ? WHERE message_id = ?');
            $stmt->bind_param('iiisssi', $message->type, $message->account_id, $message->friend_id, $message->subject, $message->message, $message->sent, $message->message_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save messages!');
        }
    }

    public function delete_message($message)
    {
        if ($message instanceof Messages) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Messages WHERE message_id = ?');
            $stmt->bind_param('i', $message->message_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete message');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Notifications
    //
    /////////////////////////////////////////////////////////

    public function add_note($account_id, $content, $link, $icon, $notified, $type)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Notifications (account_id, content, link, icon, notified, type) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('issssi', $account_id, $content, $link, $icon, $notified, $type);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_note($note_id)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Notifications WHERE notification_id = ?');
        $stmt->bind_param('i', $note_id);
        $stmt->execute();
        $stmt->store_result();

        $notes = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($notification_id, $account_id, $content, $link, $icon, $notified, $type);

            require_once(dirname(__FILE__) . '/sql/social/Notifications.php');
            while ($stmt->fetch()) {
                $notes = new Notifications($notification_id, $account_id, $content, $link, $icon, $notified, $type);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($notes != null) {
            return $notes;
        }
    }

    public function get_notes($user_id, $type)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Notifications WHERE account_id = ? AND type = ?');
        $stmt->bind_param('ii', $user_id, $type);
        $stmt->execute();
        $stmt->store_result();

        $notes = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($notification_id, $account_id, $content, $link, $icon, $notified, $type);

            $notes = array();
            require_once(dirname(__FILE__) . '/sql/social/Notifications.php');
            while ($stmt->fetch()) {
                array_push($notes, new Notifications($notification_id, $account_id, $content, $link, $icon, $notified, $type));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($notes != null) {
            return $notes;
        }
    }

    public function update_note($note){
        if ($note instanceof Notifications) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Notifications SET account_id = ?, content = ?, link = ?, icon = ?, notified = ?, type = ? WHERE notification_id = ?');
            $stmt->bind_param('issssii', $note->account_id, $note->content, $note->link, $note->icon, $note->notified, $note->type, $note->notification_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save notification!');
        }
    }

    public function delete_note($note){
        require_once(dirname(__FILE__) . '/sql/social/Notifications.php');

        if ($note instanceof Notifications) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Notifications WHERE notification_id = ?');
            $stmt->bind_param('i', $note->notification_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete notification');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Posts
    //
    /////////////////////////////////////////////////////////

    public function add_post($account_id, $location, $message, $likes, $posted)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Posts (account_id, location, message, likes, posted) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('iisis', $account_id, $location, $message, $likes, $posted);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_post_on_wall($user_id)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Posts WHERE location = ?');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($post_id, $account_id, $location, $message, $likes, $posted);
            $post = array();

            while ($stmt->fetch()) {
                require_once(dirname(__FILE__) . '/sql/social/Posts.php');
                array_push($post, new Posts($post_id, $account_id, $location, $message, $likes, $posted));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($post != null) {
            return $post;
        }
    }

    public function update_post($post)
    {
        if ($post instanceof Posts) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Posts SET account_id = ?, location = ?, message = ?, likes = ?, posted = ? WHERE post_id = ?');
            $stmt->bind_param('iisiii', $post->account_id, $post->location, $post->message, $post->likes, $post->posted, $post->post_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save notification!');
        }
    }

    public function delete_post($post)
    {
        if ($post instanceof Posts) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Posts WHERE post_id = ?');
            $stmt->bind_param('i', $post->post_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete posts');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Requests
    //
    /////////////////////////////////////////////////////////

    public function add_request($requester_id, $requested_id)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Requests (requester_id, requested_id) VALUES (?, ?)');
        $stmt->bind_param('ii', $requester_id, $requested_id);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_requests($user_id)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Requests WHERE requested_id = ?');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->store_result();

        $requests = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($request_id, $requester_id, $requested_id);

            $requests = array();
            require_once(dirname(__FILE__) . '/sql/social/Requests.php');
            while ($stmt->fetch()) {
                array_push($requests, new Requests($request_id, $requester_id, $requested_id));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($requests != null) {
            return $requests;
        }
    }

    public function update_request($request)
    {
        if ($request instanceof Requests) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Requests SET requester_id = ?, requested_id = ? WHERE request_id = ?');
            $stmt->bind_param('iii', $request->requester_id, $request->requested_id, $request->request_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save notification!');
        }
    }

    public function delete_request($request)
    {
        if ($request instanceof Requests) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Requests WHERE request_id = ?');
            $stmt->bind_param('i', $request->request_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete requests');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Blocks
    //
    /////////////////////////////////////////////////////////

    public function add_block($blocker_id, $blocked_id)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Blocks (blocker_id, blocked_id) VALUES (?, ?)');
        $stmt->bind_param('ii', $blocker_id, $blocked_id);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_block($user_id)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Blocks WHERE blocker_id = ? OR blocked_id = ?');
        $stmt->bind_param('ii', $user_id, $user_id);
        $stmt->execute();
        $stmt->store_result();

        $block = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($block_id, $blocker_id, $blocked_id);

            while ($stmt->fetch()) {
                require_once(dirname(__FILE__) . '/sql/social/User_Blocks.php');
                $block = new User_Blocks($block_id, $blocker_id, $blocked_id);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($block != null) {
            return $block;
        }
    }

    public function update_block($block)
    {
        if ($block instanceof User_Blocks) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Blocks SET blocker_id = ?, blocked_id = ? WHERE block_id = ?');
            $stmt->bind_param('iii', $block->blocker_id, $block->blocked_id, $block->block_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save block!');
        }
    }

    public function delete_block($block)
    {
        if ($block instanceof User_Blocks) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Blocks WHERE block_id = ?');
            $stmt->bind_param('i', $block->block_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete block');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Wall Comment
    //
    /////////////////////////////////////////////////////////

    public function add_wall_comment($post_id, $account_id, $message, $likes, $posted)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Comments (post_id, account_id, message, likes, posted) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('iisis', $post_id, $account_id, $message, $likes, $posted);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_wall_comment_using_post($user_id)
    {
        $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Comments WHERE post_id = ?');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->store_result();

        $comment = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($comment_id, $post_id, $account_id, $message, $likes, $posted);

            while ($stmt->fetch()) {
                require_once(dirname(__FILE__) . '/sql/social/Wall_Comment.php');
                $comment = new Wall_Comment($comment_id, $post_id, $account_id, $message, $likes, $posted);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($comment != null) {
            return $comment;
        }
    }

    public function update_wall_comment($comment)
    {
        if ($comment instanceof Wall_Comment) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Comments SET post_id = ?, account_id = ?, message = ?, likes = ?, posted = ? WHERE comment_id = ?');
            $stmt->bind_param('iisisi', $comment->post_id, $comment->account_id, $comment->message, $comment->likes, $comment->posted, $comment->comment_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save block!');
        }
    }

    public function delete_wall_comment($comment)
    {
        if ($comment instanceof Wall_Comment) {
            $mysqli = new mysqli($this->byte_host, $this->byte_user, $this->byte_pass, 'frostbyt_Social');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Comments WHERE comment_id = ?');
            $stmt->bind_param('i', $comment->block_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete comment');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Byte_User
    //
    /////////////////////////////////////////////////////////

    public function add_byte_user($account_id, $access_token, $sub_date, $donation_amount, $points, $rank_id, $inventory, $active_items, $xp, $achievements)
    {
        $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Account');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Byte_Users (account_id, access_token, sub_date, donation_amount, points, rank_id, inventory, active_items, xp, achievements) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('issiiissis', $account_id, $access_token, $sub_date, $donation_amount, $points, $rank_id, $inventory, $active_items, $xp, $achievements);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_byte_user($user_id)
    {
        $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Account');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Byte_Users WHERE account_id = ?');
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->store_result();

        $user = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $account_id, $access_token, $sub_date, $donation_amount, $points, $rank_id, $inventory, $active_items, $xp, $achievements);

            while ($stmt->fetch()) {
                require_once(dirname(__FILE__) . '/sql/account/Byte_Users.php');
                $user = new Byte_Users($user_id, $account_id, $access_token, $sub_date, $donation_amount, $points, $rank_id, $inventory, $active_items, $xp, $achievements);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($user != null) {
            return $user;
        }
    }

    public function get_byte_users()
    {
        $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Account');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Byte_Users');
        $stmt->execute();
        $stmt->store_result();

        $users = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $account_id, $access_token, $sub_date, $donation_amount, $points, $rank_id, $inventory, $active_items, $xp, $achievements);
            $users = array();

            require_once(dirname(__FILE__) . '/sql/account/Byte_Users.php');
            while ($stmt->fetch()) {
                array_push($users , new Byte_Users($user_id, $account_id, $access_token, $sub_date, $donation_amount, $points, $rank_id, $inventory, $active_items, $xp, $achievements));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($users != null) {
            return $users;
        }
    }

    public function update_byte_user($user)
    {
        if ($user instanceof Byte_Users) {
            $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Account');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Byte_Users SET account_id = ?, access_token = ?, sub_date = ?, donation_amount = ?, points = ?, rank_id = ?, inventory = ?, active_items = ?, xp = ?, achievements = ? WHERE user_id = ?');
            $stmt->bind_param('issiiissisi', $user->account_id, $user->access_token, $user->sub_date, $user->donation_amount, $user->points, $user->rank_id, $user->inventory, $user->active_items, $user->xp, $user->achievements, $user->user_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save user!');
        }
    }

    public function delete_byte_user($user)
    {
        if ($user instanceof Byte_Users) {
            $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Account');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Byte_Users WHERE user_id = ?');
            $stmt->bind_param('i', $user->user_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete comment');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Ranks
    //
    /////////////////////////////////////////////////////////

    public function add_rank($rank, $rank_index, $tag_image)
    {
        $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Account');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Ranks (rank, rank_index, tag_image) VALUES (?, ?, ?)');
        $stmt->bind_param('sis', $rank, $rank_index, $tag_image);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_rank($rank_id)
    {
        $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Account');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Ranks WHERE rank_id = ?');
        $stmt->bind_param('i', $rank_id);
        $stmt->execute();
        $stmt->store_result();

        $rank = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($rank_id, $rank, $rank_index, $tag_image);

            while ($stmt->fetch()) {
                require_once(dirname(__FILE__) . '/sql/account/Ranks.php');
                $rank = new Ranks($rank_id, $rank, $rank_index, $tag_image);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($rank != null) {
            return $rank;
        }
    }

    public function update_rank($rank)
    {
        if ($rank instanceof Ranks) {
            $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Account');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Ranks SET rank = ?, rank_index = ?, tag_image = ? WHERE rank_id = ?');
            $stmt->bind_param('sisi', $rank->rank_id, $rank->rank, $rank->rank_index, $rank->tag_image);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save rank!');
        }
    }

    public function delete_rank($rank)
    {
        if ($rank instanceof Ranks) {
            $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Account');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Ranks WHERE rank_id = ?');
            $stmt->bind_param('i', $rank->rank_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete comment');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Items
    //
    /////////////////////////////////////////////////////////

    public function add_item($name, $description, $gph, $perk_ids, $quality, $item_type, $item_image)
    {
        $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Items (name, description, gph, perk_ids, quality, item_type, item_image) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssissss', $name, $description, $gph, $perk_ids, $quality, $item_type, $item_image);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_item($item_id)
    {
        $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Items WHERE item_id = ?');
        $stmt->bind_param('i', $item_id);
        $stmt->execute();
        $stmt->store_result();

        $rank = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($item_id, $name, $description, $gph, $perk_ids, $quality, $item_type, $item_image);

            while ($stmt->fetch()) {
                require_once(dirname(__FILE__) . '/sql/items/Items.php');
                $rank = new Items($item_id, $name, $description, $gph, $perk_ids, $quality, $item_type, $item_image);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($rank != null) {
            return $rank;
        }
    }

    public function get_items()
    {
        $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Items');
        $stmt->execute();
        $stmt->store_result();

        $rank = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($item_id, $name, $description, $gph, $perk_ids, $quality, $item_type, $item_image);
            $rank = array();

            while ($stmt->fetch()) {
                require_once(dirname(__FILE__) . '/sql/items/Items.php');
                array_push($rank, new Items($item_id, $name, $description, $gph, $perk_ids, $quality, $item_type, $item_image));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($rank != null) {
            return $rank;
        }
    }

    public function update_item($item)
    {
        if ($item instanceof Items) {
            $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Items SET name = ?, description = ?, gph = ?, perk_ids = ?, quality = ?, item_type = ?, item_image = ? WHERE item_id = ?');
            $stmt->bind_param('ssiisiii', $item->name, $item->description, $item->gph, $item->perk_ids, $item->quality, $item->item_type, $item->item_image, $item->item_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save item!');
        }
    }

    public function delete_item($item)
    {
        if ($item instanceof Items) {
            $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Items WHERE item_id = ?');
            $stmt->bind_param('i', $item->item_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete item');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  News
    //
    /////////////////////////////////////////////////////////

    public function add_news($account_id, $title, $content, $written)
    {
        $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_News');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO News (account_id, title, content, written) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('isss', $account_id, $title, $content, $written);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_new($news_id)
    {
        $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_News');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM News WHERE news_id = ?');
        $stmt->bind_param('i', $news_id);
        $stmt->execute();
        $stmt->store_result();

        $news = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($news_id, $account_id, $title, $content, $written);

            while ($stmt->fetch()) {
                require_once(dirname(__FILE__) . '/sql/news/News.php');
                $news = new News($news_id, $account_id, $title, $content, $written);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($news != null) {
            return $news;
        }
    }

    public function get_news()
    {
        $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_News');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM News');
        $stmt->execute();
        $stmt->store_result();

        $news = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($news_id, $account_id, $title, $content, $written);

            $news = array();
            require_once(dirname(__FILE__) . '/sql/news/News.php');
            while ($stmt->fetch()) {
                array_push($news, new News($news_id, $account_id, $title, $content, $written));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($news != null) {
            return $news;
        }
    }

    public function update_news($news)
    {
        if ($news instanceof News) {
            $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_News');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE News SET account_id = ?, title = ?, content = ?, written = ? WHERE news_id = ?');
            $stmt->bind_param('isssi', $news->account_id, $news->title, $news->content, $news->written, $news->news_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save news!');
        }
    }

    public function delete_news($news)
    {
        if ($news instanceof News) {
            $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_News');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM News WHERE news_id = ?');
            $stmt->bind_param('i', $news->news_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete news');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Perks
    //
    /////////////////////////////////////////////////////////

    public function add_perks($name, $description)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Perks (name, description) VALUES (?, ?)');
        $stmt->bind_param('ss', $name, $description);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_perks()
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Perks');
        $stmt->execute();
        $stmt->store_result();

        $perks = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($perk_id, $name, $description);
            require_once(dirname(__FILE__) . '/sql/items/Perks.php');
            $perks = array();

            while ($stmt->fetch()) {
                array_push($perks, new Perks($perk_id, $name, $description));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($perks != null) {
            return $perks;
        }
    }

    public function get_perk($perk_id)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Perks WHERE perk_id = ?');
        $stmt->bind_param('i', $perk_id);
        $stmt->execute();
        $stmt->store_result();

        $perks = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($perk_id, $name, $description);
            require_once(dirname(__FILE__) . '/sql/items/Perks.php');

            while ($stmt->fetch()) {
                $perks = new Perks($perk_id, $name, $description);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($perks != null) {
            return $perks;
        }
    }

    public function update_perks($perks)
    {
        if ($perks instanceof Perks) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Perks SET name = ?, description = ? WHERE perk_id = ?');
            $stmt->bind_param('ssi', $perks->name, $perks->description, $perks->perk_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save perk!');
        }
    }

    public function delete_perk($perks)
    {
        if ($perks instanceof Perks) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Perks WHERE perk_id = ?');
            $stmt->bind_param('i', $perks->perk_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete perk');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Category
    //
    /////////////////////////////////////////////////////////

    public function add_category($name, $description, $type)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Util');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Category (name, description, type) VALUES (?, ?, ?)');
        $stmt->bind_param('ssi', $name, $description, $type);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_categories($type)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Util');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Category WHERE type = ?');
        $stmt->bind_param('i', $type);
        $stmt->execute();
        $stmt->store_result();

        $category = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($category_id, $name, $description, $type);
            require_once(dirname(__FILE__) . '/sql/util/Category.php');
            $category = array();

            while ($stmt->fetch()) {
                array_push($category, new Category($category_id, $name, $description, $type));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($category != null) {
            return $category;
        }
    }

    public function get_category($category_id)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Util');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Category WHERE category_id = ?');
        $stmt->bind_param('i', $category_id);
        $stmt->execute();
        $stmt->store_result();

        $category = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($category_id, $name, $description, $type);
            require_once(dirname(__FILE__) . '/sql/util/Category.php');

            while ($stmt->fetch()) {
                $category = new Category($category_id, $name, $description, $type);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($category != null) {
            return $category;
        }
    }

    public function update_category($category)
    {
        if ($category instanceof Category) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Util');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Category SET name = ?, description = ?, type = ? WHERE category_id = ?');
            $stmt->bind_param('ssii', $category->name, $category->description, $category->type, $category->category_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save category!');
        }
    }

    public function delete_category($category)
    {
        if ($category instanceof Category) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Util');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Category WHERE category_id = ?');
            $stmt->bind_param('i', $category->category_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete category');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Item_Type
    //
    /////////////////////////////////////////////////////////

    public function add_item_type($name, $description, $can_use)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Item_Types (name, description, can_use) VALUES (?, ?, ?)');
        $stmt->bind_param('ssi', $name, $description, $can_use);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_item_types()
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Item_Types');
        $stmt->execute();
        $stmt->store_result();

        $types = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($type_id, $name, $description, $can_use);
            require_once(dirname(__FILE__) . '/sql/items/Item_Type.php');
            $types = array();

            while ($stmt->fetch()) {
                array_push($types, new Item_Type($type_id, $name, $description, $can_use));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($types != null) {
            return $types;
        }
    }

    public function get_item_type($type_id)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Item_Types WHERE type_id = ?');
        $stmt->bind_param('i', $type_id);
        $stmt->execute();
        $stmt->store_result();

        $types = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($type_id, $name, $description, $can_use);
            require_once(dirname(__FILE__) . '/sql/items/Item_Type.php');

            while ($stmt->fetch()) {
                $types = new Item_Type($type_id, $name, $description, $can_use);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($types != null) {
            return $types;
        }
    }

    public function update_item_type($item_types)
    {
        if ($item_types instanceof Item_Type) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Item_Types SET name = ?, description = ?, can_use = ? WHERE type_id = ?');
            $stmt->bind_param('ssii', $item_types->name, $item_types->description, $item_types->can_use, $item_types->type_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save item type!');
        }
    }

    public function delete_item_type($item_types)
    {
        if ($item_types instanceof Item_Type) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Item_Types WHERE type_id = ?');
            $stmt->bind_param('i', $item_types->type_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to item type');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Qualities
    //
    /////////////////////////////////////////////////////////

    public function add_quality($name, $description)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Qualities (name, description) VALUES (?, ?)');
        $stmt->bind_param('ss', $name, $description);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_qualities()
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Qualities');
        $stmt->execute();
        $stmt->store_result();

        $qualities = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($quality_id, $name, $description);
            require_once(dirname(__FILE__) . '/sql/items/Qualities.php');
            $qualities = array();

            while ($stmt->fetch()) {
                array_push($qualities, new Qualities($quality_id, $name, $description));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($qualities != null) {
            return $qualities;
        }
    }

    public function get_quality($quality_id)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Qualities WHERE quality_id = ?');
        $stmt->bind_param('i', $quality_id);
        $stmt->execute();
        $stmt->store_result();

        $qualities = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($quality_id, $name, $description);
            require_once(dirname(__FILE__) . '/sql/items/Qualities.php');

            while ($stmt->fetch()) {
                $qualities = new Qualities($quality_id, $name, $description);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($qualities != null) {
            return $qualities;
        }
    }

    public function update_quality($quality)
    {
        if ($quality instanceof Qualities) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Qualities SET name = ?, description = ? WHERE quality_id = ?');
            $stmt->bind_param('ssi', $quality->name, $quality->description, $quality->quality_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save quality!');
        }
    }

    public function delete_quality($quality)
    {
        if ($quality instanceof Qualities) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Items');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Qualities WHERE quality_id = ?');
            $stmt->bind_param('i', $quality->quality_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete quality');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Store
    //
    /////////////////////////////////////////////////////////

    public function add_store($category, $item, $price)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Store');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Store (category, item, price) VALUES (?, ?, ?)');
        $stmt->bind_param('iii', $category, $item, $price);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_stores()
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Store');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Store');
        $stmt->execute();
        $stmt->store_result();

        $store = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($store_id, $category, $item, $price);
            require_once(dirname(__FILE__) . '/sql/store/Store.php');
            $store = array();

            while ($stmt->fetch()) {
                array_push($store, new Store($store_id, $category, $item, $price));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($store != null) {
            return $store;
        }
    }

    public function get_stores_using_category($category)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Store');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Store WHERE category = ?');
        $stmt->bind_param('i', $category);
        $stmt->execute();
        $stmt->store_result();

        $store = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($store_id, $category, $item, $price);
            require_once(dirname(__FILE__) . '/sql/store/Store.php');
            $store = array();

            while ($stmt->fetch()) {
                array_push($store, new Store($store_id, $category, $item, $price));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($store != null) {
            return $store;
        }
    }

    public function get_store($store_id)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Store');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Store WHERE store_id = ?');
        $stmt->bind_param('i', $store_id);
        $stmt->execute();
        $stmt->store_result();

        $store = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($store_id, $category, $item, $price);
            require_once(dirname(__FILE__) . '/sql/store/Store.php');

            while ($stmt->fetch()) {
                $store = new Store($store_id, $category, $item, $price);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($store != null) {
            return $store;
        }
    }

    public function update_store($store)
    {
        if ($store instanceof Store) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Store');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Store SET category = ?, item = ?, price = ? WHERE store_id = ?');
            $stmt->bind_param('iiii', $store->category, $store->item, $store->price, $store->store_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save store!');
        }
    }

    public function delete_store($store)
    {
        if ($store instanceof Store) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Store');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Store WHERE store_id = ?');
            $stmt->bind_param('i', $store->store_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete store');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Purchases
    //
    /////////////////////////////////////////////////////////

    public function add_purchase($account_id, $item_bought, $cost, $time, $email, $paypal_id)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Store');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Purchases (account_id, item_bought, cost, time, email, paypal_id) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('iiissi', $account_id, $item_bought, $cost, $time, $email, $paypal_id);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_purchases()
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Store');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Purchases');
        $stmt->execute();
        $stmt->store_result();

        $purchases = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($purchase_id, $account_id, $item_bought, $cost, $time, $email, $paypal_id);
            require_once(dirname(__FILE__) . '/sql/store/Purchases.php');
            $purchases = array();

            while ($stmt->fetch()) {
                array_push($purchases, new Purchases($purchase_id, $account_id, $item_bought, $cost, $time, $email, $paypal_id));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($purchases != null) {
            return $purchases;
        }
    }

    public function get_purchase($purchase_id)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Store');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Purchases WHERE purchase_id = ?');
        $stmt->bind_param('i', $purchase_id);
        $stmt->execute();
        $stmt->store_result();

        $purchase = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($purchase_id, $account_id, $item_bought, $cost, $time, $email, $paypal_id);
            require_once(dirname(__FILE__) . '/sql/store/Purchases.php');

            while ($stmt->fetch()) {
                $purchase = new Purchases($purchase_id, $account_id, $item_bought, $cost, $time, $email, $paypal_id);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($purchase != null) {
            return $purchase;
        }
    }

    public function update_purchase($purchase)
    {
        if ($purchase instanceof Purchases) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Store');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Purchases SET account_id = ?, item_bought = ?, cost = ?, time = ?, email = ?, paypal_id = ? WHERE purchase_id = ?');
            $stmt->bind_param('iiissii', $purchase->account_id, $purchase->item_bought, $purchase->cost, $purchase->time, $purchase->email, $purchase->paypal_id, $purchase->purchase_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save purchase!');
        }
    }

    public function delete_purchase($purchase)
    {
        if ($purchase instanceof Purchases) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Store');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Purchases WHERE purchase_id = ?');
            $stmt->bind_param('i', $purchase->purchase_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete purchase');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Sponsors
    //
    /////////////////////////////////////////////////////////

    public function add_sponsor($name, $image, $link, $facebook, $twitter)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Sponsors (name, image, link, facebook, twitter) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('sssss', $name, $image, $link, $facebook, $twitter);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_sponsors()
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Sponsors');
        $stmt->execute();
        $stmt->store_result();

        $sponsors = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($sponsor_id, $name, $image, $link, $facebook, $twitter);
            require_once(dirname(__FILE__) . '/sql/activity/Sponsors.php');
            $sponsors = array();

            while ($stmt->fetch()) {
                array_push($sponsors, new Sponsors($sponsor_id, $name, $image, $link, $facebook, $twitter));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($sponsors != null) {
            return $sponsors;
        }
    }

    public function get_sponsor($sponsor_id)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Sponsors WHERE sponsor_id = ?');
        $stmt->bind_param('i', $sponsor_id);
        $stmt->execute();
        $stmt->store_result();

        $sponsors = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($sponsor_id, $name, $image, $link, $facebook, $twitter);
            require_once(dirname(__FILE__) . '/sql/activity/Sponsors.php');

            while ($stmt->fetch()) {
                $sponsors = new Sponsors($sponsor_id, $name, $image, $link, $facebook, $twitter);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($sponsors != null) {
            return $sponsors;
        }
    }

    public function update_sponsor($sponsor)
    {
        if ($sponsor instanceof Sponsors) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Sponsors SET name = ?, image = ?, link = ?, facebook = ?, twitter = ? WHERE sponsor_id = ?');
            $stmt->bind_param('sssssi', $sponsor->name, $sponsor->image, $sponsor->link, $sponsor->facebook, $sponsor->twitter, $sponsor->sponsor_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save sponsor!');
        }
    }

    public function delete_sponsor($sponsor)
    {
        if ($sponsor instanceof Sponsors) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Sponsors WHERE sponsor_id = ?');
            $stmt->bind_param('i', $sponsor->sponsor_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete sponsor');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Alerts
    //
    /////////////////////////////////////////////////////////

    public function add_alert($alert_type, $alert_content)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Alerts (alert_type, alert_content) VALUES (?, ?)');
        $stmt->bind_param('is', $alert_type, $alert_content);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_alerts()
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Alerts');
        $stmt->execute();
        $stmt->store_result();

        $alerts = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($alert_id, $alert_type, $alert_content);
            require_once(dirname(__FILE__) . '/sql/activity/Alerts.php');
            $alerts = array();

            while ($stmt->fetch()) {
                array_push($alerts, new Alerts($alert_id, $alert_type, $alert_content));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($alerts != null) {
            return $alerts;
        }
    }

    public function get_alert($alert_id)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Alerts WHERE alert_id = ?');
        $stmt->bind_param('i', $alert_id);
        $stmt->execute();
        $stmt->store_result();

        $alerts = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($alert_id, $alert_type, $alert_content);
            require_once(dirname(__FILE__) . '/sql/activity/Alerts.php');

            while ($stmt->fetch()) {
                $alerts = new Alerts($alert_id, $alert_type, $alert_content);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($alerts != null) {
            return $alerts;
        }
    }

    public function update_alert($alert)
    {
        if ($alert instanceof Alerts) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Alerts SET alert_type = ?, alert_content WHERE alert_id = ?');
            $stmt->bind_param('isi', $alert->alert_type, $alert->alert_content, $alert->alert_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save alert!');
        }
    }

    public function delete_alert($alert)
    {
        if ($alert instanceof Alerts) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Alerts WHERE alert_id = ?');
            $stmt->bind_param('i', $alert->alert_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete alert');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Alerts
    //
    /////////////////////////////////////////////////////////

    public function add_property($key, $value)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Util');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO Properties (property_key, value) VALUES (?, ?)');
        $stmt->bind_param('ss', $key, $value);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_properties()
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Util');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Properties');
        $stmt->execute();
        $stmt->store_result();

        $properties = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($property_id, $key, $value);
            require_once(dirname(__FILE__) . '/sql/util/Properties.php');
            $properties = array();

            while ($stmt->fetch()) {
                array_push($properties, new Properties($property_id, $key, $value));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($properties != null) {
            return $properties;
        }
    }

    public function get_property($key)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Util');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM Properties WHERE property_key = ?');
        $stmt->bind_param('s', $key);
        $stmt->execute();
        $stmt->store_result();

        $properties = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($property_id, $key, $value);
            require_once(dirname(__FILE__) . '/sql/util/Properties.php');

            while ($stmt->fetch()) {
                $properties = new Properties($property_id, $key, $value);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($properties != null) {
            return $properties;
        }
    }

    public function update_property($property)
    {
        if ($property instanceof Properties) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Util');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('UPDATE Properties SET property_key = ?, value = ? WHERE property_id = ?');
            $stmt->bind_param('ssi', $property->key, $property->value, $property->property_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to save property!');
        }
    }

    public function delete_property($property)
    {
        if ($property instanceof Properties) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Util');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM Properties WHERE property_id = ?');
            $stmt->bind_param('i', $property->property_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete property');
        }
    }

    //////////////////////////////////////////////////////////
    //
    //                  Alerts
    //
    /////////////////////////////////////////////////////////

    public function add_dj($account_id, $video_link)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('INSERT INTO DJ (account_id, video_link) VALUES (?, ?)');
        $stmt->bind_param('is', $account_id, $video_link);
        $stmt->execute();

        $mysqli->close();
    }

    public function get_djs()
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM DJ');
        $stmt->execute();
        $stmt->store_result();

        $djs = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($dj_id, $account_id, $video_link);
            require_once(dirname(__FILE__) . '/sql/activity/DJ.php');
            $djs = array();

            while ($stmt->fetch()) {
                array_push($djs, new DJ($dj_id, $account_id, $video_link));
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($djs != null) {
            return $djs;
        }
    }

    public function get_dj($value)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        if(is_numeric($value)) {
            $stmt = $mysqli->prepare('SELECT * FROM DJ WHERE account_id = ?');
            $stmt->bind_param('i', $value);
        }else{
            $stmt = $mysqli->prepare('SELECT * FROM DJ WHERE video_link = ?');
            $stmt->bind_param('s', $value);
        }
        $stmt->execute();
        $stmt->store_result();

        $dj = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($dj_id, $account_id, $video_link);
            require_once(dirname(__FILE__) . '/sql/activity/DJ.php');

            while ($stmt->fetch()) {
                $dj = new DJ($dj_id, $account_id, $video_link);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($dj != null) {
            return $dj;
        }
    }

    public function get_dj_id($value)
    {
        $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

        if ($mysqli->connect_errno > 0) {
            die('Unable to connect to database [' . $mysqli->connect_error . ']');
        }

        $stmt = $mysqli->prepare('SELECT * FROM DJ WHERE account_id = ?');
        $stmt->bind_param('i', $value);
        $stmt->execute();
        $stmt->store_result();

        $dj = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($dj_id, $account_id, $video_link);
            require_once(dirname(__FILE__) . '/sql/activity/DJ.php');

            while ($stmt->fetch()) {
                $dj = new DJ($dj_id, $account_id, $video_link);
            }
        } else {
            return null;
        }

        $mysqli->close();

        if ($dj != null) {
            return $dj;
        }
    }

    public function delete_dj($dj)
    {
        if ($dj instanceof DJ) {
            $mysqli = $mysqli = new mysqli($this->sql_hostname, $this->sql_username, $this->sql_password, 'mahyar12_Activity');

            if ($mysqli->connect_errno > 0) {
                die('Unable to connect to database [' . $mysqli->connect_error . ']');
            }

            $stmt = $mysqli->prepare('DELETE FROM DJ WHERE dj_id = ?');
            $stmt->bind_param('i', $dj->dj_id);
            $stmt->execute();

            $mysqli->close();
        } else {
            die('Unable to delete dj');
        }
    }
}

// IP: 198.245.55.118
// Mask: 255.255.255.0
// Gateway: 198.245.55.254