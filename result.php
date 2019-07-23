<?php
  /*
    arp spoofing with nmap nping command
    sudo nping --arp-type arp-reply --source-mac 00:0c:29:43:ec:da --source-ip 10.0.0.3 -c 100 10.0.0.2
  */
?>

<html>

<head>
  <title>Request</title>
  <link rel="stylesheet" type="text/css" href="result_style.css">
<head>

<body>
  <div class="result-box">
    <h1 id="result-heading">Result</h1>

    <?php

      $protocol=$_POST['protocol'];
      $filter=$_POST['filter'];
      $numberOfpackets=$_POST['number-of-packets'];

      if ($filter == "all-packets")
      {
        echo "<table style = 'width: 100%;'>";
      }
      else
        echo "<table>";

      //  initial tcp dump command
      $command = "sudo tcpdump -w output.pcap";
      //  add number of packets to initial command
      $command = $command . " -c " . $numberOfpackets;
      //  add interface
      $command = $command . " -i enp0s3";
      //  protocol to filter
      $command = $command . " " . $protocol;

      //  error check command
      //echo $command . "\n";
      //$command = $command . " " . "2>&1";

      //  execute command on shell and display
      echo shell_exec($command);

      //  command to read output packet file
      $command = "sudo tcpdump -r output.pcap -nn";

      //  output table header
      echo "<tr";
      echo "<th><h3>" . strtoupper($protocol) . " Protocol" . "</h3></th>";
      if ($filter == "timestamp" || $filter == "all-packets"){
        echo "<th>Timestamp</th>";
      }
      if ($filter == "source-ip" || $filter == "all-packets"){
        echo "<th>Source IPv4</th>";
      }
      if ($filter == "source-port" || $filter == "all-packets"){
        echo "<th>Source Port</th>";
      }
      if ($filter == "source-mac" || $filter == "all-packets"){
        echo "<th>Source MAC</th>";
      }
      if ($filter == "destination-ip" || $filter == "all-packets"){
        echo "<th>Destination IPv4</th>";
      }
      if ($filter == "destination-port" || $filter == "all-packets"){
        echo "<th>Destination Port</th>";
      }
      if ($filter == "destination-mac" || $filter == "all-packets"){
        echo "<th>Destination MAC</th>";
      }
      if ($filter == "packet-length" || $filter == "all-packets"){
        echo "<th>Packet length</th>";
      }
      echo "<tr>";

      //  tcp packets commands
      if($protocol == "tcp"){
          exec($command . " | cut -d ' ' -f 1", $timestamp, $returnVal);
          exec($command . " | cut -d ' ' -f 3 | cut -d '.' -f 1,2,3,4", $sourceIP, $returnVal);
          exec($command . " | cut -d ' ' -f 3 | cut -d '.' -f 5", $sourcePort, $returnVal);
          exec($command . " -e | cut -d ' ' -f 2", $sourceMAC, $returnVal);
          exec($command . " | cut -d ' ' -f 5 | cut -d '.' -f 1,2,3,4", $destinationIP, $returnVal);
          exec($command . " | cut -d ' ' -f 5 | cut -d '.' -f 5 | cut -d ':' -f 1", $destinationPort, $returnVal);
          exec($command . " -e | cut -d ' ' -f 4 | cut -d ',' -f 1", $destinationMAC, $returnVal);
          exec($command . " | awk '{print $(NF)}'", $packetLength, $returnVal);

          for($i = 0; $i < sizeof($timestamp); $i += 1){
            echo "<tr>";
            if($filter == "timestamp" || $filter == "all-packets"){
                echo "<td>".$timestamp[$i]."\n</td>";
            }
            if($filter == "source-ip" || $filter == "all-packets"){
                echo "<td>".$sourceIP[$i]."\n</td>";
            }
            if($filter == "source-port" || $filter == "all-packets"){
                echo "<td>".$sourcePort[$i]."\n</td>";
            }
            if($filter == "source-mac" || $filter == "all-packets"){
                echo "<td>".$sourceMAC[$i]."\n</td>";
            }
            if($filter == "destination-ip" || $filter == "all-packets"){
                echo "<td>".$destinationIP[$i]."\n</td>";
            }
            if($filter == "destination-port" || $filter == "all-packets"){
                echo "<td>".$destinationPort[$i]."\n</td>";
            }
            if($filter == "destination-mac" || $filter == "all-packets"){
                echo "<td>".$destinationMAC[$i]."\n</td>";
            }
            if($filter == "packet-length" || $filter == "all-packets"){
                echo "<td>".$packetLength[$i]."\n</td>";
            }
            echo "</tr>";
          }
        }
        //  udp packets commands
        else if($protocol == "udp"){
          exec($command . " | cut -d ' ' -f 1", $timestamp, $returnVal);
          exec($command . " | cut -d ' ' -f 3 | cut -d '.' -f 1,2,3,4", $sourceIP, $returnVal);
          exec($command . " | cut -d ' ' -f 3 | cut -d '.' -f 5", $sourcePort, $returnVal);
          exec($command . " -e | cut -d ' ' -f 2", $sourceMAC, $returnVal);
          exec($command . " | cut -d ' ' -f 5 | cut -d '.' -f 1,2,3,4", $destinationIP, $returnVal);
          exec($command . " | cut -d ' ' -f 5 | cut -d '.' -f 5 | cut -d ':' -f 1", $destinationPort, $returnVal);
          exec($command . " -e | cut -d ' ' -f 4 | cut -d ',' -f 1", $destinationMAC, $returnVal);
          exec($command . " | awk '{print $(NF)}' | cut -b 1 --complement | rev | cut -b 1 --complement | rev", $packetLength, $returnVal);

          for($i = 0; $i < sizeof($timestamp); $i += 1){
            echo "<tr>";
            if($filter == "timestamp" || $filter == "all-packets"){
                echo "<td>".$timestamp[$i]."\n</td>";
            }
            if($filter == "source-ip" || $filter == "all-packets"){
                echo "<td>".$sourceIP[$i]."\n</td>";
            }
            if($filter == "source-port" || $filter == "all-packets"){
                echo "<td>".$sourcePort[$i]."\n</td>";
            }
            if($filter == "source-mac" || $filter == "all-packets"){
                echo "<td>".$sourceMAC[$i]."\n</td>";
            }
            if($filter == "destination-ip" || $filter == "all-packets"){
                echo "<td>".$destinationIP[$i]."\n</td>";
            }
            if($filter == "destination-port" || $filter == "all-packets"){
                echo "<td>".$destinationPort[$i]."\n</td>";
            }
            if($filter == "destination-mac" || $filter == "all-packets"){
                echo "<td>".$destinationMAC[$i]."\n</td>";
            }
            if($filter == "packet-length" || $filter == "all-packets"){
                echo "<td>".$packetLength[$i]."\n</td>";
            }
            echo "</tr>";
          }
        }
        //  arp packets
        else{
          exec($command . " | cut -d ' ' -f 1", $timestamp, $returnVal);
          exec($command . " -e | cut -d ' ' -f 2", $sourceMAC, $returnVal);
          exec($command . " -e | cut -d ' ' -f 4 | cut -d ',' -f 1", $destinationMAC, $returnVal);
          exec($command . " | awk '{print $(NF)}'", $packetLength, $returnVal);

          for($i = 0; $i < sizeof($timestamp); $i += 1){
            echo "<tr>";

            if($filter == "timestamp" || $filter == "all-packets"){
                echo "<td>".$timestamp[$i]."\n</td>";
            }
            if($filter == "source-ip" || $filter == "all-packets"){
                echo "<td>".""."\n</td>";
            }
            if($filter == "source-port" || $filter == "all-packets"){
                echo "<td>".""."\n</td>";
            }
            if($filter == "source-mac" || $filter == "all-packets"){
                echo "<td>".$sourceMAC[$i]."\n</td>";
            }
            if($filter == "destination-ip" || $filter == "all-packets"){
                echo "<td>".""."\n</td>";
            }
            if($filter == "destination-port" || $filter == "all-packets"){
                echo "<td>".""."\n</td>";
            }
            if($filter == "destination-mac" || $filter == "all-packets"){
                echo "<td>".$destinationMAC[$i]."\n</td>";
            }
            if($filter == "packet-length" || $filter == "all-packets"){
                echo "<td>".$packetLength[$i]."\n</td>";
            }
            echo "</tr>";
          }
        }

        echo "</table>";
      ?>

   </div>
   <footer class="footer"><p>Created by: Tushar Sharma</p></footer>

 </body>

 </html>
