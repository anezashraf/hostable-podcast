import React from 'react'
import CreateEpisodeForm from '../../Components/Forms/CreateEpisodeForm'
import {bindActionCreators} from "redux";
import {fetchDetails, updateDetails, uploadImage} from "../../modules/podcast";
import {connect} from "react-redux";
import {fetchEpisodes, updateEpisode, uploadAudio, saveNew} from "../../modules/episode";

class CreateNewEpisode extends React.Component {

    handleSave = (title, description, audio, image) => {
        console.log(sdsdsd);
        this.props.saveNew(title, description, audio, image);
    };

    render() {

        let {isImageUploading, isAudioUploading} = this.props;

        return (
            <section>
                <CreateEpisodeForm
                    uploadAudio={uploadAudio}
                    uploadImage={uploadImage}
                    handleSave={this.handleSave}
                    isImageUploading={isImageUploading}
                    isAudioUploading={isAudioUploading}
                />
            </section>
        )
    }
}

const mapStateToProps = ({ episode }) => ({
    episodes: episode.episodes,
    isAudioUploading: episode.isAudioUploading,
    isImageUploading: episode.isImageUploading
});

const mapDispatchToProps = dispatch =>
    bindActionCreators(
        {
            saveNew,
        },
        dispatch
    );

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(CreateNewEpisode)