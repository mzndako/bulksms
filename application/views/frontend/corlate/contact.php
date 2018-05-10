<style>
    .contact_body {

    }

    .contact_container {
        max-width: 600px;
        margin: 2em auto;
        overflow: hidden;
        background: white;
        border-radius: 5px;
        font: 16px Helvetica;
    }

    .contact_container .message, .contact, .name, .contact_header, .contact_footer, .contact_container textareaa {
        display: block;
        padding: 0;
        margin: 0;
        border: 0;
        clear: both;
        overflow: hidden;
    }

    .contact_header, .contact_footer {
        height: 75px;
        background: rgba(0, 0, 0, 0.05);
        line-height: 75px;
        padding-left: 20px;
        border-radius: 5px 5px 0 0;
    }
    .contact_header h1, .contact_footer h1 {
        font-size: 1.2em;
        text-transform: uppercase;
        color: rgba(51, 51, 51, 0.4);
    }

    .contact_first, .last {
        float: left;
        width: 278px;
        margin: 0;
        padding: 0 0 0 20px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        height: 50px;
    }

    .last {
        width: 279px;
        border-left: 0;
    }
    .contact_footer {
        height: 49px;
        border-top: 1px dashed rgba(0, 0, 0, 0.3);
        border-radius: 0 0 5px 5px;
        padding-left: 0;
        padding-right: 20px;
    }
    .contact_footer button {
        height: 32px;
        background: #e74c3c;
        border-radius: 5px;
        border: 0;
        margin: 7px 0;
        color: white;
        float: right;
        padding: 0 20px 0 20px;
        border-bottom: 3px solid #c0392b;
        transition: all linear .2s;
    }
    .contact_footer button:hover {
        background: #c0392b;
    }
    .contact_footer button:focus {
        outline: none;
    }


</style>
<div class='contact_container'>
    <div class="contact_header">
        <h1>Send us a suggestion!</h1>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class='form-group'>
                <label class="bmd-label-floating">First Name</label>
                <input class='form-control' type='text'>
            </div>
        </div>
        <div class="col-sm-6">
            <div class='form-group'>
                <label class="bmd-label-floating">Last Name</label>
                <input class='form-control' type='text'>
            </div>
        </div>
    </div>

    <div class='form-group'>
        <label class="bmd-label-floating">Email Address</label>
        <input class='form-control' name="email" type='text'>
    </div>
    <div class='form-group'>
        <label class="bmd-label-floating">Your Suggestions Here!</label>
        <textarea class="form-control" name="message"></textarea>
    </div>

    <div class="contact_footer">
        <button class="btn btn-success btn-raised">Send Suggestion</button>
    </div>
</div>