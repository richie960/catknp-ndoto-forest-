import requests
import json

# Your API endpoint
api_url = "https://api.openai.com/v1/completions"

# Your API key
api_key = "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"

# Data to send to the API
data = {
    "model": "text-davinci-003",
    "prompt": "Once upon a time",
    "max_tokens": 50
}

# Headers with authorization
headers = {
    "Content-Type": "application/json",
    "Authorization": f"Bearer {api_key}"
}

# Make the POST request
response = requests.post(api_url, data=json.dumps(data), headers=headers)

# Print the response
print(response.json())
