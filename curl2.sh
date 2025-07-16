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

  response=$(curl -s -X POST "$RPC_URL" -H "$HEADER" -d "{
    \"jsonrpc\": \"2.0\",
    \"id\": \"1\",
    \"method\": \"$method\",
    \"params\": $params
  }")

  if command -v jq >/dev/null 2>&1; then
    echo "$response" | jq
  else
    echo "$response"
  fi
}

function menu() {
  echo ""
  echo "=== Wallet RPC Menu ==="
  echo "1) getStatus"
  echo "2) getAddresses"
  echo "3) getBalance"
  echo "4) sendTransaction"
  echo "5) getTransaction"
  echo "6) validateAddress"
  echo "0) Esci"
  echo "========================"
}

while true; do
  menu
  read -p "Scegli un'opzione: " choice
  case $choice in
    1) call_rpc "getStatus" "{}" ;;
    2) call_rpc "getAddresses" "{}" ;;
    3)
      addr=$(prompt "Indirizzo")
      call_rpc "getBalance" "{\"address\": \"$addr\"}"
      ;;
    4)
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
    5)
      tx=$(prompt "Hash transazione")
      call_rpc "getTransaction" "{\"transactionHash\": \"$tx\"}"
      ;;
    6)
      addr=$(prompt "Indirizzo da validare")
      call_rpc "validateAddress" "{\"address\": \"$addr\"}"
      ;;
    0) echo "Uscita..."; break ;;
    *) echo "Opzione non valida." ;;
  esac
done
