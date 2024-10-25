<?php
$sql = "SELECT event_id FROM event_participants WHERE user_id=:user_id";
                                        $result = connectDB()->query($sql);
                                        $check = $result->fetchAll(PDO::FETCH_ASSOC);
                                        function registered() {
                                            global $event,$check;
                                            foreach($check as $exists) {
                                                if($check['event_id'] == $event["event_id"] )
                                                return true;
                                            }
                                        }
                                    ?>