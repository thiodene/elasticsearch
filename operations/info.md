# The information there makes sense to me, but it leaves a few stones unturned:

# /{index}/{type}/{id}
Clear: I can use PUT to add a document because I specified the id. It is my responsibility that the id doesn't clash with an existing document, or it will be overwritten.
Unclear: Would it be correct (allowed) to use POST here?
Unclear: Does EVERY POST store a document? Or are there certain "special" documents that change configuration?

# /{index}/{type}
Clear: I MUST use POST to add a document, because I don't specify an id.
Unclear: Can I safely add documents without fearing overwrite?
Unclear: Does EVERY POST store a document? Or are there certain "special" documents that change configuration?

# /{index}
Unclear: what will a POST operation do here? Or a PUT operation? I found examples that change configuration, but are there other possibilities?
