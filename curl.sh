#!/bin/bash

RPC_URL="http://127.0.0.1:17082/json_rpc"
HEADER="Content-Type: application/json"

function prompt() {
  read -p "$1: " REPLY
  echo "$REPLY"
}

function call_rpc() {
  local method=$1
  local params=$2
  curl -s -X POST "$RPC_URL" -H "$HEADER" -d "{
    \"jsonrpc\": \"2.0\",
    \"id\": \"1\",
    \"method\": \"$method\",
    \"params\": $params
  }" | jq
}

function menu() {
  echo ""
  echo "=== Wallet RPC Menu ==="
  echo "1) save"
  echo "2) export"
  echo "3) reset"
  echo "4) getViewKey"
  echo "5) getMnemonicSeed"
  echo "6) getSpendKeys"
  echo "7) getStatus"
  echo "8) nodeFeeInfo"
  echo "9) getAddresses"
  echo "10) createAddress"
  echo "11) createAddressList"
  echo "12) deleteAddress"
  echo "13) validateAddress"
  echo "14) createIntegratedAddress"
  echo "15) getBalance"
  echo "16) sendTransaction"
  echo "17) createDelayedTransaction"
  echo "18) getDelayedTransactionHashes"
  echo "19) deleteDelayedTransaction"
  echo "20) sendDelayedTransaction"
  echo "21) getBlockHashes"
  echo "22) getTransactionHashes"
  echo "23) getTransaction"
  echo "24) getTransactions"
  echo "25) getUnconfirmedTransactionHashes"
  echo "26) sendFusionTransaction"
  echo "27) estimateFusion"
  echo "0) Esci"
  echo "========================"
}

while true; do
  menu
  read -p "Scegli un'opzione: " choice
  case $choice in
    1) call_rpc "save" "{}" ;;
    2) file=$(prompt "Nome file"); call_rpc "export" "{\"fileName\": \"$file\"}" ;;
    3) height=$(prompt "Altezza da cui resettare"); call_rpc "reset" "{\"scanHeight\": $height}" ;;
    4) call_rpc "getViewKey" "{}" ;;
    5) addr=$(prompt "Indirizzo"); call_rpc "getMnemonicSeed" "{\"address\": \"$addr\"}" ;;
    6) addr=$(prompt "Indirizzo"); call_rpc "getSpendKeys" "{\"address\": \"$addr\"}" ;;
    7) call_rpc "getStatus" "{}" ;;
    8) call_rpc "nodeFeeInfo" "{}" ;;
    9) call_rpc "getAddresses" "{}" ;;
    10) call_rpc "createAddress" "{}" ;;
    11) keys=$(prompt "Chiavi segrete (JSON array)"); call_rpc "createAddressList" "{\"spendSecretKeys\": $keys}" ;;
    12) addr=$(prompt "Indirizzo da eliminare"); call_rpc "deleteAddress" "{\"address\": \"$addr\"}" ;;
    13) addr=$(prompt "Indirizzo da validare"); call_rpc "validateAddress" "{\"address\": \"$addr\"}" ;;
    14) addr=$(prompt "Indirizzo base"); pid=$(prompt "Payment ID"); call_rpc "createIntegratedAddress" "{\"address\": \"$addr\", \"paymentId\": \"$pid\"}" ;;
    15) addr=$(prompt "Indirizzo"); call_rpc "getBalance" "{\"address\": \"$addr\"}" ;;
    16)
      src=$(prompt "Indirizzo sorgente")
      dst=$(prompt "Indirizzo destinazione")
      amt=$(prompt "Importo (atomic units)")
      call_rpc "sendTransaction" "{
        \"addresses\": [\"$src\"],
        \"transfers\": [{\"address\": \"$dst\", \"amount\": $amt}],
        \"fee\": 100000,
        \"anonymity\": 3
      }"
      ;;
    17)
      src=$(prompt "Indirizzo sorgente")
      dst=$(prompt "Indirizzo destinazione")
      amt=$(prompt "Importo (atomic units)")
      call_rpc "createDelayedTransaction" "{
        \"addresses\": [\"$src\"],
        \"transfers\": [{\"address\": \"$dst\", \"amount\": $amt}],
        \"fee\": 100000,
        \"anonymity\": 3
      }"
      ;;
    18) call_rpc "getDelayedTransactionHashes" "{}" ;;
    19) tx=$(prompt "Hash transazione"); call_rpc "deleteDelayedTransaction" "{\"transactionHash\": \"$tx\"}" ;;
    20) tx=$(prompt "Hash transazione"); call_rpc "sendDelayedTransaction" "{\"transactionHash\": \"$tx\"}" ;;
    21)
      idx=$(prompt "Indice primo blocco")
      cnt=$(prompt "Numero blocchi")
      call_rpc "getBlockHashes" "{\"firstBlockIndex\": $idx, \"blockCount\": $cnt}"
      ;;
    22)
      addrs=$(prompt "Indirizzi (JSON array)")
      cnt=$(prompt "Numero blocchi")
      call_rpc "getTransactionHashes" "{\"addresses\": $addrs, \"blockCount\": $cnt}"
      ;;
    23) tx=$(prompt "Hash transazione"); call_rpc "getTransaction" "{\"transactionHash\": \"$tx\"}" ;;
    24)
      addrs=$(prompt "Indirizzi (JSON array)")
      cnt=$(prompt "Numero blocchi")
      call_rpc "getTransactions" "{\"addresses\": $addrs, \"blockCount\": $cnt}"
      ;;
    25)
      addrs=$(prompt "Indirizzi (JSON array)")
      call_rpc "getUnconfirmedTransactionHashes" "{\"addresses\": $addrs}"
      ;;
    26)
      th=$(prompt "Soglia")
      dst=$(prompt "Indirizzo destinazione")
      call_rpc "sendFusionTransaction" "{\"threshold\": $th, \"addresses\": [], \"destinationAddress\": \"$dst\"}"
      ;;
    27)
      th=$(prompt "Soglia")
      addrs=$(prompt "Indirizzi (JSON array)")
      call_rpc "estimateFusion" "{\"threshold\": $th, \"addresses\": $addrs}"
      ;;
    0) echo "Uscita..."; break ;;
    *) echo "Opzione non valida." ;;
  esac
done
