import requests
import json

RPC_URL = "http://127.0.0.1:17082/json_rpc"

metodi_supportati = [
    "save",
    "export",
    "reset",
    "getViewKey",
    "getMnemonicSeed",
    "getSpendKeys",
    "getStatus",
    "getAddresses",
    "createAddress",
    "createAddressList",
    "deleteAddress",
    "validateAddress",
    "createIntegratedAddress",
    "getBalance",
    "sendTransaction",
    "createDelayedTransaction",
    "getDelayedTransactionHashes",
    "deleteDelayedTransaction",
    "sendDelayedTransaction",
    "getBlockHashes",
    "getTransactionHashes",
    "getTransaction",
    "getTransactions",
    "getUnconfirmedTransactionHashes",
    "sendFusionTransaction",
    "estimateFusion"
]

def call_rpc(method, params=None):
    if params is None:
        params = {}
    payload = {
        "jsonrpc": "2.0",
        "id": "1",
        "method": method,
        "params": params
    }
    try:
        response = requests.post(RPC_URL, json=payload)
        response.raise_for_status()
        return response.json()
    except Exception as e:
        print(f"Errore nella chiamata RPC: {e}")
        return None

def chiedi_parametri(metodo):
    params = {}

    if metodo == "export":
        params["fileName"] = input("Inserisci nome file export: ").strip()
    elif metodo == "reset":
        params["scanHeight"] = int(input("Inserisci scanHeight (numero intero): ").strip())
    elif metodo in ("getMnemonicSeed", "getSpendKeys", "getBalance",
                    "deleteAddress", "validateAddress"):
        params["address"] = input("Inserisci indirizzo: ").strip()
    elif metodo == "createIntegratedAddress":
        address = input("Inserisci indirizzo base: ").strip()
        paymentId = input("Inserisci payment ID: ").strip()
        params = {"address": address, "paymentId": paymentId}
    elif metodo == "sendTransaction":
        source = input("Inserisci indirizzo sorgente: ").strip()
        dest = input("Inserisci indirizzo destinazione: ").strip()
        amount = int(input("Inserisci importo (in atomic units): ").strip())
        fee = int(input("Inserisci fee (es. 100000): ").strip())
        anonymity = int(input("Inserisci livello anonimato (es. 3): ").strip())
        params = {
            "addresses": [source],
            "transfers": [{"address": dest, "amount": amount}],
            "fee": fee,
            "anonymity": anonymity
        }
    else:
        # Nessun parametro richiesto
        params = {}

    return params

def mostra_menu():
    print("Seleziona un metodo RPC da chiamare:")
    for i, metodo in enumerate(metodi_supportati, start=1):
        print(f"[{i}] {metodo}")
    print("[0] Esci")
    scelta = input("Scelta: ").strip()
    if not scelta.isdigit():
        return -1
    return int(scelta)

def main():
    while True:
        scelta = mostra_menu()
        if scelta == 0:
            print("Uscita...")
            break
        if scelta < 1 or scelta > len(metodi_supportati):
            print("Scelta non valida.\n")
            continue

        metodo_selezionato = metodi_supportati[scelta - 1]
        print(f"Chiamata metodo: {metodo_selezionato}")

        params = chiedi_parametri(metodo_selezionato)
        result = call_rpc(metodo_selezionato, params)

        print("Risposta JSON-RPC:")
        print(json.dumps(result, indent=4, ensure_ascii=False))
        input("\nPremi INVIO per continuare...")

if __name__ == "__main__":
    main()
